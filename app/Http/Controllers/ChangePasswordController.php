<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Response;

class ChangePasswordController extends Controller {
    public function changePassword(ChangePasswordRequest $changePasswordRequest) {
        $input = $changePasswordRequest->all();

        return $this->getPasswordResetsRow($input)->get()->count() > 0 ? $this->change($input) : $this->rowNotFound();
    }

    private function getPasswordResetsRow($input) {
        return PasswordReset::email($input['email'])->token($input['token']);
    }

    private function change($input) {
        $email = $input['email'];
        $password = $input['password'];

        User::email($email)->update([
            'password' => bcrypt($password)
        ]);

        $this->getPasswordResetsRow($input)->delete();

        return response()->json([
           'data' => 'Password Successfully Changed'
        ], Response::HTTP_CREATED);
    }

    private function rowNotFound() {
        return response()->json([
           'error' => 'Token or Email is incorrect'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
