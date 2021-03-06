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

Route::any('/dashboard/getoffer', 'DashboardController@getoffer')->name('getoffer');
Route::any('/dashboard/wallethistory', 'DashboardController@wallethistory')->name('wallethistory');
Route::any('/dashboard/getbalance', 'DashboardController@getbalance')->name('getbalance');
Route::any('/dashboard', 'DashboardController@index')->name('dashboarddata');


Route::group(['prefix'=>'course'], function(){
    Route::any('/subcategory', 'DataController@getpackagesubcategory')->name('getpackagesubcategory');
});
Route::group(['prefix'=>'user'], function(){
    Route::any('/sharetextdata', 'DataController@sharetextdata')->name('sharetextdata');
    Route::any('/notification', 'DataController@notification')->name('notification');
    Route::any('/course', 'DataController@course')->name('course');
    Route::any('/ebooknotes', 'DataController@ebooknotes')->name('ebooknotes');
    Route::any('/getinstitutedetail', 'DataController@getinstitutedetail')->name('getinstitutedetail');
    Route::any('/freestudymaterial', 'DataController@freestudymaterial')->name('freestudymaterial');
    Route::any('/studymaterialcat', 'DataController@studymaterialcat')->name('studymaterialcat');
    Route::any('/institutecategory', 'DataController@institutecategory')->name('institutecategory');
    Route::any('/testseries', 'DataController@testseries')->name('testseries');
    Route::any('/freetestseries', 'DataController@freetestseries')->name('freetestseries');
    Route::any('/institutes', 'DataController@institutes')->name('institutes');
    Route::any('/packagedetail', 'DataController@packagedetail')->name('packagedetail');
    Route::any('/videocat', 'DataController@videocat')->name('videocat');
    Route::any('/testcat', 'DataController@testcat')->name('testcat');
    Route::any('/dailyquiz', 'DataController@dailyquiz')->name('dailyquiz');
    Route::any('/livevideos', 'DataController@livevideos')->name('livevideos');
    Route::any('/insreview', 'DataController@insreview')->name('insreview');
    Route::any('/syllabus', 'DataController@syllabus')->name('syllabus');
    Route::any('/review', 'DataController@review')->name('review');
    Route::any('/videosubcategory', 'DataController@videosubcategory')->name('videosubcategory');
    Route::any('/purchasedtest', 'DataController@purchasedtest')->name('purchasedtest');
    Route::any('/packagedtest', 'DataController@packagedtest')->name('packagedtest');

    
    Route::any('/review', 'DataController@review')->name('review');
    //Route::any('/videocat1', 'DataController@videocat1')->name('videocat1');

       
});
Route::group(['prefix'=>'cart'], function(){

    Route::any('/applypromo', 'CartController@applypromo')->name('applypromo');
    Route::any('/completetransaction', 'CartController@completetransaction')->name('completetransaction');
    Route::any('/mypurchase', 'CartController@mypurchase')->name('mypurchase');
    Route::any('/mylibrary', 'CartController@myLibrary')->name('myLibrary');

});


///Route::auto('/login', LoginController::class);
