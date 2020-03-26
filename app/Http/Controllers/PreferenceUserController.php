<?php

namespace App\Http\Controllers;
use App\Http\Requests\PreferenceUserRequest;
use App\Models\PreferenceUser;
use App\Services\LogService;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Intervention\Image\Facades\Image;
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
    use UploadFile;

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

    /**
     * @OA\Post(
     *     path="/account/avatar/update",
     *     tags={"authentication"},
     *     summary="Changes user avatar",
     *     operationId="PreferenceUserControllerUpdateAvatar",
     *     @OA\Parameter(
     *         name="avatar",
     *         in="query",
     *         description="Image jpeg,png,jpg,gif",
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
    public function updateAvatar(Request $request) {
        $input = $request->all();

        $validation = new PreferenceUserRequest($input, 'updateAvatar');

        if ($validation->fails()) {
            return $validation->failResponse();
        }

        $name = time() . '.' . explode('/', explode(':', substr($input['avatar'], 0, strpos($input['avatar'], ';')))[1])[1];
        $filePath = public_path('uploads/images/avatars/') . $name;

        Image::make($input['avatar'])->save($filePath);

        $preferenceUser = PreferenceUser::where('id', auth()->user()->preferenceUser()->first()->id)->first();
        $preferenceUser->avatar = config('app.back_url') . '/' . 'uploads/images/avatars/' . $name;
        $success = $preferenceUser->save();

        return LogService::update($success, [
           'avatar' => $preferenceUser->avatar
        ]);
    }
}
