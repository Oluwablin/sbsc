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

    //PRODUCTS
    Route::get('fetch/all/products', 								    'ProductController@listAllProducts');
    Route::get('fetch/a/particular/product/{id}', 						'ProductController@listAProduct');
    Route::post('create/new/product', 								    'ProductController@storeProduct');
    Route::post('update/a/particular/product/{id}', 					'ProductController@updateProduct');
    Route::delete('delete/a/particular/product/{id}', 					'ProductController@deleteProduct');

    //PRODUCT CATEGORIES
    Route::get('fetch/all/product/categories', 							'ProductCategoryController@listAllProductCategories');
    Route::get('fetch/a/particular/product/category/{id}', 				'ProductCategoryController@listAProductCategory');
    Route::post('create/new/product/category', 							'ProductCategoryController@storeProductCategory');
    Route::put('update/a/particular/product/category/{id}', 			'ProductCategoryController@updateProductCategory');
    Route::delete('delete/a/particular/product/category/{id}', 			'ProductCategoryController@deleteProductCategory');

    //CALLING PRODUCT FACTORY TO CREATE 50 PRODUCTS
    Route::post('create/new/product/with/factory', 					    'ProductController@runProduct');

    //GROUPING ANAGRAMS TOGETHER
    Route::get('group/these/anagrams', 					                'TechnicalQuestionsController@groupAnagram');

    //RETURN INDEX OF A GIVEN ARRAY
    Route::get('fetch/index/in/an/array/{arr}/{n}', 					'TechnicalQuestionsController@indexArray');

    //FACTORIAL OF 13
    Route::get('fetch/factorial/of/a/number/{number}', 					'TechnicalQuestionsController@numberFactorial');

    //STATES IN DESCENDING ORDER
    Route::get('fetch/states/by/length/in/descending/order', 	        'TechnicalQuestionsController@sortLengthDescending');

});
