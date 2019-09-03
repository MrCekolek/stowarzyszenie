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

    Route::post('email/exist', 'UserController@emailExist');
    Route::get('account/activate', 'AuthController@accountActivate');
    Route::post('account/login', 'AuthController@accountLogin');
    Route::post('account/register', 'AuthController@accountRegister');
    Route::post('account/register/resend', 'AuthController@accountResendRegister');
    Route::post('account/password/reset', 'ResetPasswordController@accountPasswordReset');
    Route::post('account/password/change', 'ChangePasswordController@accountPasswordChange');
    Route::post('logout', 'AuthController@logout');
    Route::post('lang/get', 'PreferenceUserController@getLang');
    Route::post('lang/set', 'PreferenceUserController@setLang');
});
