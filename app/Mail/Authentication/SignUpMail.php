<?php

namespace App\Mail\Authentication;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignUpMail extends Mailable {
    use Queueable, SerializesModels;

    public $lang,
        $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($lang, $token) {
        $this->lang = $lang;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->markdown('email.auth.signUp')->with([
            'lang' => $this->lang,
            'token' => $this->token
        ]);
    }
}
