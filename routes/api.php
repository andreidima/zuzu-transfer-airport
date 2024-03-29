<?php

use Illuminate\Http\Request;

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

//Andrei
        // Route::middleware('auth:api')->get('/user', function (Request $request) {
        //     return $request->user();
        // });

        Route::middleware('auth:api')->get('/user', 'UserController@AuthRouteAPI');

Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/confirmare-plata', 'PlataOnlineController@confirmarePlata')->name('confirmare-plata');
});
// Route::post('/confirmare-plata', 'PlataOnlineController@confirmarePlata')->name('confirmare-plata');