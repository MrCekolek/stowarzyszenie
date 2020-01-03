<?php

namespace App\Http\Controllers;
use App\Http\Requests\PreferenceUserRequest;
use App\Models\PreferenceUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use JWTAuth;
use Config;

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
