<?php

namespace App\Http\Controllers;
use App\Http\Requests\PreferenceUserRequest;
use App\Models\PreferenceUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use JWTAuth;
use Config;


/**
 * Class PreferenceUserController
 *
 * @package stowarzyszenie\controllers
 *
 * @author  Stowarzyszenie CIOB <CIOBstowarzyszenie@gmail.com>
 */
class PreferenceUserController extends Controller {
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['setLang']]);
    }

    public static function getGeolocation() {
        try {
            $regionAPI = json_decode(
                file_get_contents(
                    config('api.geo_app_url') . '?apiKey=' . config('api.geo_app_key')
                ), true);

            return $regionAPI;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @OA\Post(
     *     path="/lang/set",
     *     tags={"language"},
     *     summary="Changes users language",
     *     operationId="setLang",
     *     @OA\Parameter(
     *         name="lang",
     *         in="query",
     *         description="Language in:en,pl,ru",
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
    public function setLang(Request $request) {
        $input = $request->all();

        $validation = new PreferenceUserRequest($input, 'setLang');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        if ($user = JWTAuth::user()) {
            PreferenceUser::where('user_id', $user['id'])->update([
                'lang' => $input['lang']
            ]);
        }

        return response()->json([
            'lang' => App::getLocale()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/lang/get",
     *     tags={"language"},
     *     summary="Gets users language",
     *     operationId="getLang",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function getLang(Request $request) {
        if ($user = JWTAuth::user()) {
            $preference = PreferenceUser::where('user_id', $user['id'])
                ->first()
                ->toArray();

            return response()->json([
                'lang' => $preference['lang']
            ]);
        }
    }
}
