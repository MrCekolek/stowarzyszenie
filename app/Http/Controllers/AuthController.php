<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ActivateAccountRequest;
use App\Http\Requests\Auth\SignUpRequest;
use App\Jobs\ChangeUserTimezoneJob;
use App\Jobs\SendAuthEmailJob;
use App\Models\AffiliationUser;
use App\Models\PreferenceUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

class AuthController extends Controller {
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['accountLogin', 'accountRegister', 'accountResendRegister', 'accountActivate']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function accountLogin() {
        $credentials = request(['login_email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'error' => 'STOWARZYSZENIE.SERVER.CUSTOM.CONTROLLERS.AUTH.LOGIN.NO_EMAIL_OR_PASSWORD'
            ], Response::HTTP_UNAUTHORIZED);
        }

        if ($this->getUserRowByEmail(request(['login_email']))->count() > 0) {
            return response()->json([
                'error' => 'STOWARZYSZENIE.SERVER.CUSTOM.CONTROLLERS.AUTH.LOGIN.NOT_ACTIVATED'
            ], Response::HTTP_UNAUTHORIZED);
        }

        ChangeUserTimezoneJob::dispatchNow($credentials['login_email']);

        return $this->respondWithToken($token);
    }

    public function accountRegister(SignUpRequest $signUpRequest) {
        $input = $signUpRequest->all();

        $geolocation = $this->getGeolocation();

        if (!empty($geolocation)) {
            $time_zone = $geolocation['time_zone']['name'];
        } else {
            $time_zone = 'UTC';
        }

        $user = User::create([
            'login_email' => $input['login_email'],
            'password' => $input['password'],
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'birthdate' => $input['birthdate'],
            'gender' => $input['gender'],
            'contact_email' => $input['contact_email'],
            'phone_number' => $input['phone_number'],
        ]);

        AffiliationUser::create([
           'title' => $input['title'],
           'institution' => $input['institution'],
           'department' => $input['department'],
           'street' => $input['street'],
           'city' => $input['city'],
           'country' => $input['country'],
           'user_id' => $user['id']
        ]);

        PreferenceUser::create([
            'time_zone' => $time_zone,
            'lang' => $input['lang'],
            'user_id' => $user['id']
        ]);

        $this->send($input['login_email']);
    }

    public function accountResendRegister(Request $request) {
        $input = $request->all();

        $this->send($input['login_email']);
    }

    public function getGeolocation() {
        return PreferenceUserController::getGeolocation();
    }

    public function accountActivate(ActivateAccountRequest $activateAccountRequest) {
        $input = $activateAccountRequest->all();

        return $this->getUserRowByToken($input)->get()->count() > 0 ? $this->change($input) : $this->rowNotFound();
    }

    private function getUserRowByToken($input) {
        return User::rememberToken($input['token']);
    }

    private function getUserRowByEmail($input) {
        return User::loginEmail($input['login_email'])->emailVerifiedAt(null)->get();
    }

    private function change($input) {
        $token = $input['token'];

        User::rememberToken($token)->update([
            'remember_token' => null,
            'email_verified_at' => Carbon::now()
        ]);

        return redirect(config('app.front_url') . '/auth/login')->with([
            'message' =>  __('custom.controllers.auth.change.activated')
        ]);
    }

    private function rowNotFound() {
        return response()->json([
            'error' => __('custom.controllers.auth.row_not_found.wrong_token')
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function send($email) {
        $token = $this->createToken($email);
        SendAuthEmailJob::dispatch($email, $token);
    }

    public function createToken($email) {
        $token = Str::random(60);
        $this->saveToken($email, $token);

        return $token;
    }

    public function saveToken($email, $token) {
        User::loginEmail($email)->update([
            'remember_token' => $token
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me() {
        return response()->json(User::id(auth()->user()['id'])->with(['preferenceUser', 'affilationUser'])->first());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json([
            'message' => __('custom.controllers.auth.logout.logged_out')
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
