<?php

namespace App\Mail\Authentication;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable {
    use Queueable, SerializesModels;

    public $email,
        $lang,
        $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $lang, $token) {
        $this->email = $email;
        $this->lang = $lang;
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
            'lang' => $this->lang,
            'token' => $this->token
        ]);
    }
}
