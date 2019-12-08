<?php

namespace App\Http\Requests;

class ResetPasswordRequest extends FormRequest {
    protected $rules = [];

    public function __construct(array $input, $filter) {
        switch ($filter) {
            case 'accountPasswordReset':
                $this->checkAccountPasswordReset();

                break;
        }

        parent::__construct($input);
    }

    public function checkAccountPasswordReset() {
        $this->rules = [
            'login_email' => 'required|email|exists:users'
        ];
    }
}
