<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Queue\ShouldQueue;


class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-email [email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $bcc = $this->option('bcc');

        $send = Mail::to($email);
        if (!empty($bcc)) {
            $send->bcc($bcc);
        }
        $send->send(new VerifyEmail('ddd'));
        $this->info('Mail sent to' . $email. ' with bcc ' . $bcc??'');

        return Command::SUCCESS;
    }
}
