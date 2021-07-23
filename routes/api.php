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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::any('/', 'LoginController@index')->name('LoginWebservice');
Route::any('/login/loginwithpassword', 'LoginController@loginwithpassword')->name('login');
Route::any('/login/loginwithmobile', 'LoginController@loginwithmobile')->name('loginwithmobile');
Route::any('/login/resendotp', 'LoginController@resendotp')->name('resendotp');
Route::any('/login/verifyotp', 'LoginController@verifyotp')->name('verifyotp');
Route::any('/login/finalregister', 'LoginController@finalregister')->name('finalregister');
Route::any('/login/forgot', 'LoginController@forgot')->name('forgot');
Route::any('/login/changepassword', 'LoginController@changepassword')->name('changepassword');
Route::any('/login/updateuserprofile', 'LoginController@updateuserprofile')->name('updateuserprofile');
Route::any('/login/updatestudentprofileimage', 'LoginController@updatestudentprofileimage')->name('updatestudentprofileimage');
///Route::auto('/login', LoginController::class);
