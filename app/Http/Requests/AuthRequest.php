<?php

namespace App\Http\Requests;

class AuthRequest extends FormRequest {
    protected $rules = [];

    public function __construct(array $input, $filter) {
        switch ($filter) {
            case 'accountRegister':
                $this->checkAccountRegister();

                break;

            case 'accountActivate':
                $this->checkAccountActivate();

                break;

            case 'accountPasswordChange':
                $this->checkAccountPasswordChange();

                break;
        }

        parent::__construct($input);
    }

    public function checkAccountRegister() {
        $this->rules = [
            'login_email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'first_name' => 'required',
            'last_name' => 'required',
            'birthdate' => 'required',
            'gender' => 'required|in:F,M'
        ];
    }

    public function checkAccountActivate() {
        $this->rules = [
            'token' => 'required|exists:users,remember_token'
        ];
    }

    public function checkAccountPasswordChange() {
        $this->rules =  [
            'login_email' => 'required|email|exists:users',
            'token' => 'required|exists:password_resets',
            'password' => 'required|min:8'
        ];
    }
}
