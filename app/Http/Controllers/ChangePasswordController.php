<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ChangePasswordRequest;
use App\PasswordReset;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChangePasswordController extends Controller
{
    public function changePassword(ChangePasswordRequest $changePasswordRequest)
    {
        $input = $changePasswordRequest->all();

        return $this->getPasswordResetsRow($changePasswordRequest)->get()->count() > 0 ? $this->change($input) : $this->rowNotFound();
    }

    private function getPasswordResetsRow($changePasswordRequest)
    {
        return PasswordReset::email($changePasswordRequest['email'])->token($changePasswordRequest['token']);
    }

    private function change($input)
    {
        $email = $input['email'];
        $password = $input['password'];
        $token = $input['token'];

        $user = User::email($email)->update([
            'password' => bcrypt($password)
        ]);

        $this->getPasswordResetsRow($input)->delete();

        return response()->json([
           'data' => 'Password Successfully Changed'
        ], Response::HTTP_CREATED);
    }

    private function rowNotFound()
    {
        return response()->json([
           'error' => 'Token or Email is incorrect'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
