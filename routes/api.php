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
    Route::prefix('lang')->group(function () {
        Route::post('get', 'PreferenceUserController@getLang');
        Route::post('set', 'PreferenceUserController@setLang');
    });

    Route::prefix('translation')->group(function () {
        Route::post('', 'TranslationController@index');
        Route::post('create', 'TranslationController@create');
        Route::post('update', 'TranslationController@update');
        Route::post('destroy/{translationKey}', 'TranslationController@destroy');
        Route::post('get', 'TranslationController@getTranslation');
    });

    Route::post('email/exist', 'UserController@emailExist');
    Route::post('logout', 'AuthController@logout');

    Route::prefix('account')->group(function () {
        Route::post('me', 'AuthController@me');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('login', 'AuthController@accountLogin');
        Route::get('activate', 'AuthController@accountActivate');
        Route::post('avatar/update', 'PreferenceUserController@updateAvatar');

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
        Route::post('get', 'UserController@index');
        Route::post('{user}/get', 'UserController@show');
    });

    Route::prefix('role')->group(function () {
        Route::post('delete', 'RoleController@destroy');
        Route::post('get', 'RoleController@index');
        Route::post('create', 'RoleController@create');
        Route::post('{role}/update', 'RoleController@update');
        Route::post('{role}/permission/get', 'PermissionParentController@rolePermissions');
        Route::post('{role}/permission/update', 'PermissionParentController@updateRolePermissions');
    });

    Route::prefix('portfolio')->group(function () {
        Route::post('update', 'PortfolioController@update');

        Route::prefix('tabs')->group(function () {
            Route::post('{portfolio}/get', 'PortfolioTabController@index');
            Route::post('create', 'PortfolioTabController@create');
            Route::post('update', 'PortfolioTabController@update');
            Route::post('destroy', 'PortfolioTabController@destroy');
            Route::post('visibility/update', 'PortfolioTabController@updateVisibility');
        });

        Route::prefix('tile')->group(function () {
            Route::post('{portfolioTab}/get', 'TileController@index');
            Route::post('create', 'TileController@create');
            Route::post('update', 'TileController@update');
            Route::post('destroy', 'TileController@destroy');
            Route::post('visibility/update', 'TileController@updateVisibility');

            Route::prefix('content')->group(function () {
                Route::post('{tile}/get', 'TileContentController@index');
                Route::post('create', 'TileContentController@create');
                Route::post('update', 'TileContentController@update');
                Route::post('destroy', 'TileContentController@destroy');
                Route::post('visibility/update', 'TileContentController@updateVisibility');

                Route::prefix('content')->group(function () {
                    Route::post('{tileContent}/get', 'ContentController@index');
                    Route::post('create', 'ContentController@create');
                    Route::post('update', 'ContentController@update');
                    Route::post('destroy', 'ContentController@destroy');
                    Route::post('visibility/update', 'ContentController@updateVisibility');
                    Route::post('selected/update', 'ContentController@updateSelected');
                    Route::post('filled/update', 'ContentController@updateFilled');
                });
            });
        });
    });

    Route::prefix('interest')->group(function () {
        Route::post('get', 'InterestController@index');
        Route::post('create', 'InterestController@create');
        Route::post('{interest}/update', 'InterestController@update');
        Route::post('{interest}/destroy', 'InterestController@destroy');

        Route::prefix('user')->group(function () {
            Route::post('{user}/get', 'InterestUserController@index');
            Route::post('selected/update', 'InterestUserController@updateSelected');
        });
    });

    Route::prefix('home_navigation')->group(function () {
        Route::post('get', 'HomeNavigationController@index');
        Route::post('create', 'HomeNavigationController@create');
        Route::post('update', 'HomeNavigationController@update');
        Route::post('destroy', 'HomeNavigationController@destroy');
    });

    Route::prefix('conference')->group(function () {
        Route::post('', 'ConferenceController@index');
        Route::post('active/get', 'ConferenceController@getActive');
        Route::post('create', 'ConferenceController@create');
        Route::post('update', 'ConferenceController@update');
        Route::post('destroy', 'ConferenceController@destroy');

        Route::prefix('user')->group(function () {
            Route::post('create', 'ConferenceUserController@create');
            Route::post('update', 'ConferenceUserController@update');
            Route::post('destroy', 'ConferenceUserController@destroy');
        });

        Route::prefix('page')->group(function () {
            Route::post('', 'ConferencePageController@index');
            Route::post('create', 'ConferencePageController@create');
            Route::post('update', 'ConferencePageController@update');
            Route::post('destroy', 'ConferencePageController@destroy');
        });
    });
});
