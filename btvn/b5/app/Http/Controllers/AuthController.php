<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showRegister(): View|RedirectResponse
    {
        return Auth::check() ? redirect()->route('home') : view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create($validated);

        Log::info('registration success', [
            'user' => $user->only(['id', 'name', 'email']),
            'registered_at' => now()->toIso8601String(),
        ]);

        Mail::to($user)->send(new WelcomeMail($user));

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('status', 'Đăng ký thành công. Email chào mừng đã được gửi đến bạn.');
    }

    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            $this->logDailyCheck(request());

            return redirect()->route('home');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            Log::info('login success', [
                'user' => Auth::user()?->only(['id', 'name', 'email']),
                'logged_in_at' => now()->toIso8601String(),
            ]);
            $this->logDailyCheck($request);

            return redirect()->intended(route('home'));
        }

        Log::warning('login failed', [
            'email' => $credentials['email'],
            'ip' => $request->ip(),
        ]);

        return back()
            ->withErrors(['email' => 'Email hoặc mật khẩu không chính xác.'])
            ->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        $user = Auth::user();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('logout success', [
            'user' => $user?->only(['id', 'name', 'email']),
        ]);

        return redirect()->route('home');
    }

    public function showForgotPassword(): View|RedirectResponse
    {
        return Auth::check() ? redirect()->route('home') : view('auth.forgot-password');
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink($validated);

        if ($status === Password::RESET_LINK_SENT) {
            Log::info('password reset link requested', [
                'email' => $validated['email'],
                'requested_at' => now()->toIso8601String(),
            ]);

            return back()->with('status', 'Liên kết cấp lại mật khẩu đã được gửi đến email của bạn.');
        }

        Log::warning('password reset link request failed', [
            'email' => $validated['email'],
            'requested_at' => now()->toIso8601String(),
            'reason' => __($status),
        ]);

        return back()->withErrors(['email' => 'Không thể gửi email cấp lại mật khẩu. Vui lòng thử lại sau.']);
    }

    public function showResetPassword(string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => request()->query('email', ''),
        ]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $status = Password::reset(
            $validated,
            function (User $user, string $password): void {
                $user->forceFill([
                    'password' => $password,
                    'remember_token' => null,
                ])->save();

                Log::info('password changed', [
                    'user' => $user->only(['id', 'name', 'email']),
                    'password_changed_at' => now()->toIso8601String(),
                ]);
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Mật khẩu đã được đổi. Bạn có thể đăng nhập bằng mật khẩu mới.');
        }

        return back()->withErrors(['email' => 'Liên kết cấp lại mật khẩu không hợp lệ hoặc đã hết hạn.']);
    }

    private function logDailyCheck(Request $request): void
    {
        $user = Auth::user();

        if (!$user) {
            Log::info('daily check info', [
                'user' => null,
            ]);

            return;
        }

        $checkKey = 'daily_check_'.now()->toDateString();

        if ($request->session()->pull($checkKey) !== true) {
            Log::info('daily check info', [
                'user' => $user->only(['id', 'name', 'email']),
            ]);

            $request->session()->put($checkKey, true);
        }
    }
}
