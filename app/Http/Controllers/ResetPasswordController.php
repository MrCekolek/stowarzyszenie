<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Jobs\SendPasswordResetEmailJob;
use App\Mail\Authentication\ResetPasswordMail;
use App\Models\PasswordReset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller {
    public function accountPasswordReset(ResetPasswordRequest $resetPasswordRequest) {
        $input = $resetPasswordRequest->all();
        $email = $input['login_email'];

        $this->send($email);

        return response()->json([
            'message' => __('custom.controllers.reset_password.send_email.sent')
        ]);
    }

    public function send($email) {
        $token = $this->createToken($email);
        SendPasswordResetEmailJob::dispatch($email, $token);
    }

    public function createToken($email) {
        $tokenOld = PasswordReset::loginEmail($email)->first();
        if ($tokenOld) {
            return $tokenOld->pluck('token')[0];
        }

        $token = Str::random(60);
        $this->saveToken($email, $token);

        return $token;
    }

    public function saveToken($email, $token) {
        PasswordReset::create([
            'login_email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }
}
