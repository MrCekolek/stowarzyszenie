<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api'
], function ($router) {
//    Route::post('login', 'AuthController@login');
//    Route::post('me', 'AuthController@me');
//    Route::post('refresh', 'AuthController@refresh');

    Route::prefix('lang')->group(function () {
        Route::post('get', 'PreferenceUserController@getLang');
        Route::post('set', 'PreferenceUserController@setLang');
    });

    Route::post('email/exist', 'UserController@emailExist');
    Route::post('logout', 'AuthController@logout');

    Route::prefix('account')->group(function () {
        Route::post('login', 'AuthController@accountLogin');
        Route::get('activate', 'AuthController@accountActivate');

        Route::prefix('register')->group(function () {
            Route::post('', 'AuthController@accountRegister');
            Route::post('resend', 'AuthController@accountResendRegister');
        });

        Route::prefix('password')->group(function () {
            Route::post('reset', 'ResetPasswordController@accountPasswordReset');
            Route::post('change', 'ChangePasswordController@accountPasswordChange');
        });
    });

    Route::prefix('user')->group(function () {
        Route::get('get', 'UserController@index');
    });
});
