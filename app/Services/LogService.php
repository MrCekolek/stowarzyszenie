<?php namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class LogService {
    private const loggedOut = 'custom.controllers.auth.logout.logged_out';
    private const changePassword = 'custom.controllers.change_password.change.changed';

    /**
     * @param $data
     * @param int $httpCode
     * @return JsonResponse
     */
    public static function logResponse($data, $httpCode = 200) {
        $success = true;

        return \Response::json(
            compact('success', 'data'),
            $httpCode
        );
    }

    /**
     * @return JsonResponse
     */
    public static function logout() {
        return self::logResponse(
            __(self::loggedOut),
            Response::HTTP_UNPROCESSABLE_ENTITY
//            Response::OK
        );
    }

    /**
     * @return JsonResponse
     */
    public static function changePassword() {
        return self::logResponse(
            __(self::changePassword),
            Response::HTTP_UNPROCESSABLE_ENTITY
//            Response::CREATED
        );
    }
}
