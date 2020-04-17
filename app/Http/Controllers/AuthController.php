<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Jobs\ChangeUserTimezoneJob;
use App\Jobs\SendAuthEmailJob;
use App\Models\AffiliationUser;
use App\Models\PreferenceUser;
use App\Models\User;
use App\Services\ErrorService;
use App\Services\LogService;
use App\Traits\Translatable;
use App\Traits\ValidateLangable;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class AuthController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class AuthController extends Controller {
    use Translatable,
        ValidateLangable;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['accountLogin', 'accountRegister', 'accountResendRegister', 'accountActivate']]);
    }

    /**
     * @OA\Post(
     *     path="/account/login",
     *     tags={"authentication"},
     *     summary="Logs in user",
     *     operationId="AuthControllerAccountLogin",
     *     @OA\Parameter(
     *         name="login_email",
     *         in="query",
     *         description="User email",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User password",
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
    public function accountLogin(Request $request) {
        $credentials = $request->all([
            'login_email', 'password'
        ]);

        if (!$token = auth()->attempt($credentials)) {
            return ErrorService::noEmailOrPassword();
        }

        if ($this->getUserRowByEmail(request(['login_email']))->count() > 0) {
            return ErrorService::notActivated();
        }

        ChangeUserTimezoneJob::dispatchNow($credentials['login_email']);

        return $this->respondWithToken($token);
    }

    private function getUserRowByEmail($input) {
        return User::where('login_email', $input['login_email'])
            ->where('email_verified_at', null)
            ->get();
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => $this->me()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/account/me",
     *     tags={"authentication"},
     *     summary="Gets current logged in user",
     *     operationId="AuthControllerMe",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function me() {
        return LogService::read(true, [
            'user' => User::where('id', auth()->user()->id)
                ->with([
                    'affilationUser',
                    'portfolio',
                    'preferenceUser',
                    'roles.permissions',
                    'trackArticles'
                ])
                ->first()
                ->toArray()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/account/register",
     *     tags={"authentication"},
     *     summary="Registers user",
     *     operationId="AuthControllerAccountRegister",
     *     @OA\Parameter(
     *         name="login_email",
     *         in="query",
     *         description="User login email",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User password",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="first_name",
     *         in="query",
     *         description="User first name",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="last_name",
     *         in="query",
     *         description="User last name",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="birthdate",
     *         in="query",
     *         description="User birthdate",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="gender",
     *         in="query",
     *         description="User gender in:F,M",
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
    public function accountRegister(Request $request) {
        $input = $request->all();

        $validation = new AuthRequest($input, 'accountRegister');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

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
            'phone_number' => $input['phone_number']
        ]);

        PreferenceUser::create([
            'avatar' => $input['avatar'],
            'time_zone' => $time_zone,
            'lang' => $input['lang'],
            'user_id' => $user['id']
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

        $this->send($input['lang'], $input['login_email']);
    }

    public function getGeolocation() {
        return PreferenceUserController::getGeolocation();
    }

    public function send($lang, $email) {
        $token = $this->createToken($email);

        SendAuthEmailJob::dispatch($email, $lang, $token);
    }

    public function createToken($email) {
        $token = Str::random(60);
        $this->saveToken($email, $token);

        return $token;
    }

    public function saveToken($email, $token) {
        User::where('login_email', $email)->update([
            'remember_token' => $token
        ]);
    }

    public function accountResendRegister(Request $request) {
        $input = $request->all();

        $this->send($input['lang'], $input['login_email']);
    }

    /**
     * @OA\Get(
     *     path="/account/activate",
     *     tags={"authentication"},
     *     summary="Activates user account",
     *     operationId="AuthControllerAccountActivate",
     *     @OA\Parameter(
     *         name="token",
     *         in="query",
     *         description="Generated user unique token",
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
    public function accountActivate(Request $request) {
        $input = $request->all();

        $validation = new AuthRequest($input, 'accountActivate');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        return $this->getUserRowByToken($input)->get()->count() > 0 ? $this->change($input) : $this->rowNotFound();
    }

    private function getUserRowByToken($input) {
        return User::where('remember_token', $input['token']);
    }

    private function change($input) {
        $token = $input['token'];

        User::where('remember_token', $token)->update([
            'remember_token' => null,
            'email_verified_at' => Carbon::now()
        ]);

        return redirect(config('app.front_url') . '/auth/login')->with([
            'message' => __('custom.controllers.auth.change.activated')
        ]);
    }

    private function rowNotFound() {
        return ErrorService::wrongToken();
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     tags={"authentication"},
     *     summary="Logs out user",
     *     operationId="AuthControllerLogout",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function logout() {
        auth()->logout();

        return LogService::logout();
    }

    /**
     * @OA\Post(
     *     path="/account/refresh",
     *     tags={"authentication"},
     *     summary="Refreshes users generated token",
     *     operationId="AuthControllerRefresh",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function refresh() {
        return $this->respondWithToken(auth()->refresh());
    }
}
