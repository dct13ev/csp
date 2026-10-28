<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthController extends Controller
{
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

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            Log::info('login success', [
                'user' => Auth::user()?->only(['id', 'name', 'email']),
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
