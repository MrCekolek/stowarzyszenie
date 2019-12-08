<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
        return PasswordReset::loginEmail($input['login_email'])
            ->token($input['token']);
    }

    private function change($input) {
        $email = $input['login_email'];
        $password = $input['password'];

        $user = User::loginEmail($email)
            ->first();
        $user['password'] = $password;
        $user->save();

        $this->getPasswordResetsRow($input)
            ->delete();

        return response()->json([
           'data' => __('custom.controllers.change_password.change.changed')
        ], Response::HTTP_CREATED);
    }

    private function rowNotFound() {
        return response()->json([
           'error' =>  __('custom.controllers.change_password.row_not_found.wrong_email_or_token')
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
