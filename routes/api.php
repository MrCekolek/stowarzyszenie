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
    Route::post('login', 'AuthController@login');
    Route::get('activateAccount', 'AuthController@activateAccount');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('sendPasswordResetLink', 'ResetPasswordController@sendEmail');
    Route::post('changePassword', 'ChangePasswordController@changePassword');
    Route::post('lang/get', 'PreferenceUserController@getLang');
    Route::post('lang/set', 'PreferenceUserController@setLang');

    Route::post('email/exist', 'UserController@emailExist');
    Route::post('account/register', 'AuthController@accountRegister');
    Route::post('account/register/resend', 'AuthController@accountResendRegister');
});
