<?php

namespace App\Jobs;

use App\Mail\Authentication\ResetPasswordMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendPasswordResetEmailJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $email,
        $lang,
        $token;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $lang, $token) {
        $this->email = $email;
        $this->lang = $lang;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        Mail::to($this->email)->send(new ResetPasswordMail($this->email, $this->lang, $this->token));
    }
}
