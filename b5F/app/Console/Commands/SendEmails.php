<?php

namespace App\Console\Commands;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-email {email} {--bcc=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send mail to email address';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->argument('email');
        $bcc = $this->option('bcc');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("No user found with email {$email}.");

            return self::FAILURE;
        }

        $send = Mail::to($user);
        if (!empty($bcc)) {
            $send->bcc($bcc);
        }
        $send->send(new WelcomeMail($user));
        $this->info("Mail sent to {$email}".($bcc ? " with bcc {$bcc}" : ''));

        return self::SUCCESS;
    }
}
