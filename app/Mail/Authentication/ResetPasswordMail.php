<?php

namespace App\Mail\Authentication;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable {
    use Queueable, SerializesModels;

    public $email, $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $token) {
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->markdown('email.auth.passwordReset')->with([
            'email' => $this->email,
            'token' => $this->token
        ]);
    }
}
