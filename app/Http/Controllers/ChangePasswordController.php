<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\PasswordReset;
use App\Models\User;
use App\Services\ErrorService;
use App\Services\LogService;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller {
    public function accountPasswordChange(Request $request) {
        $input = $request->all();

        $validation = new AuthRequest($input, 'accountPasswordChange');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return $this->getPasswordResetsRow($input)->get()->count() > 0 ? $this->change($input) : $this->rowNotFound();
    }

    private function getPasswordResetsRow($input) {
        return PasswordReset::where('login_email', $input['login_email'])
            ->where('token', $input['token']);
    }

    private function change($input) {
        $email = $input['login_email'];
        $password = $input['password'];

        $user = User::where('login_email', $email)
            ->first();
        $user['password'] = $password;
        $user->save();

        $this->getPasswordResetsRow($input)
            ->delete();

        return LogService::changePassword();
    }

    private function rowNotFound() {
        return ErrorService::wrongEmailOrToken();
    }
}
