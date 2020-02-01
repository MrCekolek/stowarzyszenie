<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use App\Jobs\SendPasswordResetEmailJob;
use App\Models\PasswordReset;
use App\Services\LogService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class ResetPasswordController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class ResetPasswordController extends Controller {
    /**
     * @OA\Post(
     *     path="/account/password/reset",
     *     tags={"authentication"},
     *     summary="Resets user password",
     *     operationId="accountPasswordReset",
     *     @OA\Parameter(
     *         name="login_email",
     *         in="query",
     *         description="User email",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function accountPasswordReset(Request $request) {
        $input = $request->all();

        $validation = new ResetPasswordRequest($input, 'accountPasswordReset');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $this->send($input['login_email']);

        return LogService::accountPasswordReset();
    }

    public function send($email) {
        $token = $this->createToken($email);

        SendPasswordResetEmailJob::dispatch($email, $token);
    }

    public function createToken($email) {
        $tokenOld = PasswordReset::where('login_email', $email)->first();

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
