<?php namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ErrorService {
    private const path = 'STOWARZYSZENIE.SERVER.CUSTOM.CONTROLLERS.';

    public const FILE_UPLOAD = 'ERROR.FAILED_UPLOAD';
    public const NO_EMAIL_OR_PASSWORD = 'AUTH.LOGIN.NO_EMAIL_OR_PASSWORD';
    public const NOT_ACTIVATED = 'AUTH.LOGIN.NOT_ACTIVATED';
    public const WRONG_TOKEN = 'custom.controllers.auth.row_not_found.wrong_token';
    public const WRONG_EMAIL_OR_TOKEN = 'custom.controllers.auth.row_not_found.wrong_email_or_token';

    /**
     * @param string $error
     * @param int $httpCode
     * @return JsonResponse
     */
    public static function errorResponse($error, $httpCode = 200) {
        $success = false;

        return \Response::json(
            compact('success', 'error'),
            $httpCode
        );
    }

    /**
     * @return JsonResponse
     */
    public static function failFileUpload() {
        return self::errorResponse(
            self::FILE_UPLOAD,
            Response::HTTP_UNAUTHORIZED
        );
    }

    /**
     * @return JsonResponse
     */
    public static function noEmailOrPassword() {
        return self::errorResponse(
            self::getError(self::NO_EMAIL_OR_PASSWORD),
            Response::HTTP_UNAUTHORIZED
        );
    }

    /**
     * @return JsonResponse
     */
    public static function notActivated() {
        return self::errorResponse(
            self::getError(self::NOT_ACTIVATED),
            Response::HTTP_UNAUTHORIZED
        );
    }

    /**
     * @return JsonResponse
     */
    public static function wrongToken() {
        return self::errorResponse(
            __(self::WRONG_TOKEN),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    /**
     * @return JsonResponse
     */
    public static function wrongEmailOrToken() {
        return self::errorResponse(
            __(self::WRONG_EMAIL_OR_TOKEN),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    /**
     * @return JsonResponse
     */
    public static function logout() {
        return self::errorResponse(
            __(self::LOGOUT),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    public static function getError($error) {
        return self::path . $error;
    }
}
