<?php

namespace App\Http\Controllers;
use App\PreferenceUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use JWTAuth;
use Config;

class PreferenceUserController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['setLang']]);
    }

    public static function getGeolocation() {
        try {
            $regionAPI = json_decode(file_get_contents('https://api.ipgeolocation.io/ipgeo?apiKey=b3aaa2bd453f4a47b695b8296974c5f0'), true);
        } catch (\Exception $e) {
            return null;
        }

        return $regionAPI;
    }

    public function setLang(Request $request) {
        $input = $request->all();
        $lang = $input['lang'];

        if ($user = JWTAuth::user()) {
            PreferenceUser::UserId($user['id'])->update([
                'lang' => $lang
            ]);
        }

        return response()->json([
            'lang' => App::getLocale()
        ]);
    }

    public function getLang(Request $request) {
        if ($user = JWTAuth::user()) {
            $preference = PreferenceUser::UserId($user['id'])->first()->toArray();

            return response()->json([
                'lang' => $preference['lang']
            ]);
        }
    }
}
