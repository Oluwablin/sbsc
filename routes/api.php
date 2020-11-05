<?php

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
//NON-AUTHETICATED USERS

//REGISTER
Route::post('user/register', 									        'RegistrationController@registerUser');

//LOGIN
Route::post('user/login', 										        'AuthenticationController@loginUser');

//RESET
Route::post('send/password/email',                                      'AuthenticationController@forgotPassword');
Route::post('send/password/reset',                                      'AuthenticationController@resetPassword');


//AUTHETICATED USERS
Route::middleware('jwt.auth')->group(function () {
    Route::get('get/authenticated/user', 							    'AuthenticationController@userCurrentlyLoggedIn');
    Route::post('user/logout', 										    'AuthenticationController@logoutUser');

});
