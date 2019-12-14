<?php namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class LogService {
    private const basicPath = 'STOWARZYSZENIE.SERVER.CUSTOM.';

    private const createSuccess = self::basicPath . 'CRUD.SUCCESS.CREATE';
    private const readSuccess = self::basicPath . 'CRUD.SUCCESS.READ';
    private const updateSuccess = self::basicPath . 'CRUD.SUCCESS.UPDATE';
    private const deleteSuccess = self::basicPath . 'CRUD.SUCCESS.DELETE';

    private const createFail = self::basicPath . 'CRUD.FAIL.CREATE';
    private const readFail = self::basicPath . 'CRUD.FAIL.READ';
    private const updateFail = self::basicPath . 'CRUD.FAIL.UPDATE';
    private const deleteFail = self::basicPath . 'CRUD.FAIL.DELETE';

    private const loggedOut = self::basicPath . 'CONTROLLERS.AUTH.LOGOUT.LOGGED_OUT';
    private const changePassword = self::basicPath . 'CONTROLLERS.CHANGE_PASSWORD.CHANGE.CHANGED';
    private const accountPasswordReset = self::basicPath . 'CONTROLLERS.RESET_PASSWORD.SEND_EMAIL.SENT';

    /**
     * @param $success
     * @param $message
     * @param $data
     * @return JsonResponse
     */
    public static function logResponse($success, $message, $data) {
        return \Response::json(
            array_merge([
                'success' => $success,
                'message' => $message
            ], $data)
        );
    }

    /**
     * @param $success
     * @param $data
     * @return JsonResponse
     */
    public static function logout($success = true, $data = []) {
        return self::logResponse(
            $success,
           self::loggedOut,
            $data
        );
    }

    /**
     * @param $success
     * @param $data
     * @return JsonResponse
     */
    public static function changePassword($success = true, $data = []) {
        return self::logResponse(
            $success,
            self::changePassword,
            $data
        );
    }

    /**
     * @param bool $success
     * @param array $data
     * @return JsonResponse
     */
    public static function accountPasswordReset($success = true, $data = []) {
        return self::logResponse(
            $success,
            self::accountPasswordReset,
            $data
        );
    }

    /**
     * @param bool $success
     * @param array $data
     * @return JsonResponse
     */
    public static function create($success = true, $data = []) {
        return self::logResponse(
            $success,
            $success ? self::createSuccess : self::createFail,
            $data
        );
    }

    /**
     * @param bool $success
     * @param array $data
     * @return JsonResponse
     */
    public static function read($success = true, $data = []) {
        return self::logResponse(
            $success,
            $success ? self::readSuccess : self::readFail,
            $data
        );
    }

    /**
     * @param $success
     * @param $data
     * @return JsonResponse
     */
    public static function update($success = true, $data = []) {
        return self::logResponse(
            $success,
            $success ? self::updateSuccess : self::updateFail,
            $data
        );
    }

    /**
     * @param $success
     * @param $data
     * @return JsonResponse
     */
    public static function delete($success = true, $data = []) {
        return self::logResponse(
            $success,
            $success ? self::deleteSuccess : self::deleteFail,
            $data
        );
    }
}
