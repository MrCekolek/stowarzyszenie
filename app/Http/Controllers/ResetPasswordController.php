<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Mail\Authentication\ResetPasswordMail;
use App\PasswordReset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller {
    public function sendEmail(ResetPasswordRequest $resetPasswordRequest) {
        $input = $resetPasswordRequest->all();
        $email = $input['email'];

        $this->send($email);

        return response()->json([
            'message' => 'Reset Email is send successfully'
        ]);
    }

    public function send($email) {
        $token = $this->createToken($email);
        Mail::to($email)->send(new ResetPasswordMail($email, $token));
    }

    public function createToken($email) {
        $tokenOld = PasswordReset::email($email)->first();
        if ($tokenOld) {
            return $tokenOld->pluck('token')[0];
        }

        $token = Str::random(60);
        $this->saveToken($email, $token);

        return $token;
    }

    public function saveToken($email, $token) {
        PasswordReset::create([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }
}
