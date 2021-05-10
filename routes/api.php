<?php

use App\Http\Middleware\ValidateAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Auth Routes
 */
Route::post('/register', 'Auth\UserAuthController@register');
Route::post('/login', 'Auth\UserAuthController@login');
Route::post('/logout', 'Auth\UserAuthController@logout')->middleware('auth:api');

Route::prefix('users')->group(function () {
    /**
     * Admin Routes
     */
    Route::middleware(['auth:api', 'can:admin,App\Models\User'])->group(function () {
        Route::get('/', 'UserController@get');
        Route::post('/', 'UserController@create');
        Route::put('/{id}', 'UserController@update');
        Route::delete('/{id}', 'UserController@delete');

        Route::post('accounts', 'AccountController@create');
    });

    /**
     * User Account Routes
     */
    Route::get('accounts', 'UserController@getAccounts')->middleware(['auth:api']);

    Route::prefix('accounts/{accountId}')
    ->middleware([
        'auth:api',
        'validate.account',
        'can:accountOwner,App\Models\User,accountId'
    ])
    ->group(function () {
        Route::post('/deposit', 'AccountController@deposit');
        Route::post('/withdraw', 'AccountController@withdraw');
        Route::get('/statements', 'UserController@getStatement');
        Route::get('/', 'AccountController@find');
    });
});
