<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    public function sendEmail(ResetPasswordRequest $resetPasswordRequest)
    {
        $input = $resetPasswordRequest->all();

        $this->send($input['email']);

        return response()->json([
            'message' => 'Reset Email is send successfully'
        ]);
    }

    public function send($email)
    {
        Mail::to($email)->send(new ResetPasswordMail());
    }
}
