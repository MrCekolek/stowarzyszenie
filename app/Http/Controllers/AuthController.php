<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ActivateAccountRequest;
use App\Http\Requests\Auth\SignUpRequest;
use App\Mail\Authentication\SignUpMail;
use App\User;
use Carbon\Carbon;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

class AuthController extends Controller {
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'signup', 'activateAccount']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login() {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'error' => 'email or password doesn\'t exist'
            ], 401);
        }

        if ($this->getUserRowByEmail(request(['email']))->count() > 0) {
            return response()->json([
                'error' => 'account not activated'
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    public function signup(SignUpRequest $signUpRequest) {
        $input = $signUpRequest->all();
        User::create($input);

        $this->send($input['email']);

        return response()->json([
            'message' => 'Authentication Email is send successfully'
        ]);
    }

    public function activateAccount(ActivateAccountRequest $activateAccountRequest) {
        $input = $activateAccountRequest->all();

        return $this->getUserRowByToken($input)->get()->count() > 0 ? $this->change($input) : $this->rowNotFound();
    }

    private function getUserRowByToken($input) {
        return User::rememberToken($input['token']);
    }

    private function getUserRowByEmail($input) {
        return User::email($input['email'])->emailVerifiedAt(null)->get();
    }

    private function change($input) {
        $token = $input['token'];

        User::rememberToken($token)->update([
            'remember_token' => null,
            'email_verified_at' => Carbon::now()
        ]);

        return redirect('http://localhost:4200/login')->with([
            'message' => 'Account successfully activated'
        ]);
    }

    private function rowNotFound() {
        return response()->json([
            'error' => 'Token is incorrect'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function send($email) {
        $token = $this->createToken($email);
        Mail::to($email)->send(new SignUpMail($token));
    }

    public function createToken($email) {
        $token = Str::random(60);
        $this->saveToken($email, $token);

        return $token;
    }

    public function saveToken($email, $token) {
        User::email($email)->update([
            'remember_token' => $token
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me() {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => $this->me()
        ]);
    }
}
