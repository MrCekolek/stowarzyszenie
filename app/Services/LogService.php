<?php namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class LogService {
    private const createSuccess = 'custom.crud.success.create';
    private const readSuccess = 'custom.crud.success.read';
    private const updateSuccess = 'custom.crud.success.update';
    private const deleteSuccess = 'custom.crud.success.delete';

    private const createFail = 'custom.crud.fail.create';
    private const readFail = 'custom.crud.fail.read';
    private const updateFail = 'custom.crud.fail.update';
    private const deleteFail = 'custom.crud.fail.delete';

    private const loggedOut = 'custom.controllers.auth.logout.logged_out';
    private const changePassword = 'custom.controllers.change_password.change.changed';
    private const accountPasswordReset = 'custom.controllers.reset_password.send_email.sent';

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
            __(self::loggedOut),
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
            __(self::changePassword),
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
            __(self::accountPasswordReset),
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
            $success ? __(self::createSuccess) : __(self::createFail),
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
            $success ? __(self::readSuccess) : __(self::readFail),
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
            $success ? __(self::updateSuccess) : __(self::updateFail),
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
            $success ? __(self::deleteSuccess) : __(self::deleteFail),
            $data
        );
    }
}
