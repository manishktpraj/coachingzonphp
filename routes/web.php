<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('/', function () {
    return view('welcome');
});
Route::any('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
	 return "Cache is cleared";
});
Route::group(['prefix'=>'csadmin', 'namespace'=>'Csadmin'], function(){
     Route::get('/', 'LoginController@adminLogin')->name('adminLogin');
     Route::post('/login/loginAdminProcess', 'LoginController@adminlogincheck')->name('adminlogincheck');
    
    /*************************** 
    * Developed By Harsh Lakhera
    * 06-07-2021
    * Routing For csadmin using middleware for admin session
    * Name - dashboard, adminLogout, manageInstitutes, manageCourses, categoriesA, categoriesB
    ***/
    Route::group(['middleware'=>'Adminsession'], function(){
       
        /******Dashboard Section*******/

        Route::any('/dashboard', 'DashboardController@index')->name('dashboard');
        Route::any('/notification', 'DashboardController@notification')->name('notification');
        Route::any('/logout', 'LoginController@logout')->name('adminLogout');
        
        /******Question Section*******/
        Route::any('/all-question', 'QuestionController@index')->name('all-question');
        Route::any('/add-new-question', 'QuestionController@addNewQuestion')->name('add-new-question');
        Route::any('/question-subjects', 'QuestionController@questionSubjects')->name('question-subjects');
        Route::any('/subjectProccess', 'QuestionController@subjectProccess')->name('subjectProccess');
        Route::any('/changeStatusQCategory/{id}', 'QuestionController@changeStatusQCategory')->name('changeStatusQCategory');
        Route::any('/editsubject/{id}', 'QuestionController@questionSubjects')->name('editsubject');
        Route::any('/deletesubject/{id}', 'QuestionController@deletesubject')->name('deletesubject');
        Route::any('/exportQuestion', 'QuestionController@exportQuestion')->name('exportQuestion');
        Route::any('/importQuestion', 'QuestionController@importQuestion')->name('importQuestion');

        /******Tests/Exams Section*******/
        Route::any('/tests', 'TestsController@index')->name('tests');
        Route::any('/addnew/{id?}', 'TestsController@addNewTest')->name('addnewtest');
        Route::any('/testProccess', 'TestsController@testProccess')->name('testProccess');
        Route::any('/testStatus/{id}', 'TestsController@testStatus')->name('testStatus');
        Route::any('/testDelete/{id}', 'TestsController@testDelete')->name('testDelete');
        Route::any('/test-category/{id?}', 'TestsController@testCategory')->name('test-category');
        Route::any('/testCategoryProccess', 'TestsController@testCategoryProccess')->name('testCategoryProccess');
        Route::any('/changeStatusTCategory/{id}', 'TestsController@changeStatusTCategory')->name('changeStatusTCategory');
        Route::any('/testCatDelete/{id}', 'TestsController@testCatDelete')->name('testCatDelete');

        /******Videos Section*******/
        Route::any('/all-videos', 'VideosController@index')->name('all-videos');
        Route::any('/add-new-video/{id?}', 'VideosController@addNewVideo')->name('add-new-video');
        Route::any('/videoProccess', 'VideosController@videoProccess')->name('videoProccess');
        Route::any('/videoStatus/{id}', 'VideosController@videoStatus')->name('videoStatus');
        Route::any('/videoDelete/{id}', 'VideosController@videoDelete')->name('videoDelete');
        Route::any('/video-category/{id?}', 'VideosController@videoCategory')->name('video-category');
        Route::any('/videoCategoryProccess', 'VideosController@videoCategoryProccess')->name('videoCategoryProccess');
        Route::any('/changeStatusVCategory/{id}', 'VideosController@changeStatusVCategory')->name('changeStatusVCategory');
        Route::any('/deleteVCategory/{id}', 'VideosController@deleteVCategory')->name('deleteVCategory');
       
        /******Study Material Section*******/
        Route::any('/all-study-material', 'StudyController@index')->name('all-study-material');
        Route::any('/add-new-study/{id?}', 'StudyController@addNewStudy')->name('add-new-study');
        Route::any('/study-category/{id?}', 'StudyController@studyCategory')->name('study-category');
        Route::any('/studyCategoryProccess', 'StudyController@studyCategoryProccess')->name('studyCategoryProccess');
        Route::any('/deletescategory/{id}', 'StudyController@deleteCategory')->name('deleteCategory');
        Route::any('/changestatuscategory/{id}', 'StudyController@changeStatusCategory')->name('changeStatusCategory');
        Route::any('/studyMaterialProccess', 'StudyController@studyMaterialProccess')->name('studyMaterialProccess');
        Route::any('/studyMaterialDelete/{id}', 'StudyController@studyMaterialDelete')->name('studyMaterialDelete');
        Route::any('/studyMaterialStatus/{id}', 'StudyController@studyMaterialStatus')->name('studyMaterialStatus');
        
        /******Students Section*******/
        Route::any('/all-students', 'StudentsController@index')->name('all-students');
        Route::any('/add-new-student/{id?}', 'StudentsController@addNewStudent')->name('add-new-student');
        Route::any('/student-group/{id?}', 'StudentsController@studentGroup')->name('student-group');
        Route::any('/studentStatus/{id}', 'StudentsController@studentStatus')->name('studentStatus');
        Route::any('/studentProccess', 'StudentsController@studentProccess')->name('studentProccess');
        Route::any('/studentDelete/{id}', 'StudentsController@studentDelete')->name('studentDelete');
        Route::any('/viewstudent/{id}', 'StudentsController@viewstudent')->name('viewstudent');
        Route::any('/changeStatusgroupCategory/{id}', 'StudentsController@changeStatusgroupCategory')->name('changeStatusgroupCategory');
        Route::any('/groupProccess', 'StudentsController@groupProccess')->name('groupProccess');
        Route::any('/deletegroup/{id}', 'StudentsController@deletegroup')->name('deletegroup');
        
        /******Packages Section*******/
        Route::any('/all-packages', 'PackagesController@index')->name('all-packages');
        Route::any('/add-new-package/{id?}', 'PackagesController@addNewPackage')->name('add-new-package');
        Route::any('/packageDelete/{id}', 'PackagesController@packageDelete')->name('packageDelete');
        Route::any('/packageManage/{id?}', 'PackagesController@packageManage')->name('packageManage');
        Route::any('/packageStatus/{id}', 'PackagesController@packageStatus')->name('packageStatus');
        Route::any('/packageProccess', 'PackagesController@packageProccess')->name('packageProccess');
        Route::any('/package-category/{id?}', 'PackagesController@categoryPackage')->name('package-category');
        Route::any('/packageCategoryProccess', 'PackagesController@packageCategoryProccess')->name('packageCategoryProccess');
        Route::any('/changeStatusPCategory/{id}','PackagesController@changeStatusPCategory')->name('changeStatusPCategory');
        Route::any('/deletepcategory/{id}', 'PackagesController@deletepcategory')->name('deletepcategory');
        Route::any('/assignedvideoProccess', 'PackagesController@assignedvideoProccess')->name('assignedvideoProccess');
        Route::any('/assignedPackageProccess/{id?}', 'PackagesController@assignedPackageProccess')->name('assignedPackageProccess');
        Route::any('/deletepackagedetail/{id}', 'PackagesController@deletepackagedetail')->name('deletepackagedetail');


        

        /******Offers & Promos Section*******/
        Route::any('/offers-promos', 'OffersController@index')->name('offers-promos');
        Route::any('/add-new-offers/{id?}', 'OffersController@alloffersShow')->name('add-new-offers');
        Route::any('/offerprocess', 'OffersController@offerprocessrequest')->name('offerprocess');
        Route::any('/deleteoffer/{id}', 'OffersController@deleteoffer')->name('deleteoffer');
        Route::any('/offersStatus/{id}', 'OffersController@offersStatus')->name('offersStatus');
        
        /******Orders Section*******/
        Route::any('/order', 'OrderController@index')->name('order');
      
      /******Faculty Section*******/
        Route::any('/faculty', 'FacultyController@index')->name('faculty');
        Route::any('/add-new-faculty/{id?}', 'FacultyController@addNewFaculty')->name('add-new-faculty');
        Route::any('/view-faculty/{id?}', 'FacultyController@viewFaculty')->name('view-faculty');
        Route::any('/facultyStatus/{id}', 'FacultyController@facultyStatus')->name('facultyStatus');
        Route::any('/facultyProccess', 'FacultyController@facultyProccess')->name('facultyProccess');
        Route::any('/facultyDelete/{id}', 'FacultyController@facultyDelete')->name('facultyDelete');
        Route::any('/faculty-role/{id?}', 'FacultyController@facultyrole')->name('faculty-role');
        Route::any('/roleproccess', 'FacultyController@roleproccess')->name('roleproccess');
        Route::any('/roleStatus/{id}', 'FacultyController@roleStatus')->name('roleStatus');
        Route::any('/permission/{id}', 'FacultyController@facultypermission')->name('permission');
        Route::any('/permissionProccess', 'FacultyController@permissionProccess')->name('permissionProccess');
        
        /******Reports Section*******/
        Route::any('/reports', 'ReportsController@index')->name('reports');
        
        /******Payments Section*******/
        Route::any('/transaction', 'TransactionController@index')->name('transaction');
        
        /******Settings Section*******/
        Route::any('/store-setting', 'SettingsController@index')->name('store-setting');
        Route::any('/account-setting', 'SettingsController@accountSetting')->name('account-setting');
        Route::any('/accountProccess', 'SettingsController@accountProccess')->name('accountProccess');
        Route::any('/passProccess', 'SettingsController@passProccess')->name('passProccess');
        Route::any('/anycityajax', 'SettingsController@anycityajax')->name('anycityajax');
        Route::any('/storeProccess', 'SettingsController@storeProccess')->name('storeProccess');

        /*******Institute Section*****/

    Route::group(['prefix'=>'intitute'], function(){
        Route::any('/', 'InstituteController@index')->name('manageinstitute');
        Route::any('/status/{id}', 'InstituteController@index')->name('institutestatus');
        Route::any('/add-new-institute/{id?}', 'InstituteController@addnew')->name('add-new-institute');
        Route::any('/category/{id?}', 'InstituteCategoryController@index')->name('manageinstitutecategory');     
        Route::any('/catstatus/{id}','InstituteCategoryController@catstatus')->name('catstatus');
        Route::any('/deleteCat/{id}', 'InstituteCategoryController@deleteCat')->name('deleteCat');
        Route::any('/insCategoryProccess', 'InstituteCategoryController@insCategoryProccess')->name('insCategoryProccess');
        Route::any('/insProccess', 'InstituteController@insProccess')->name('insProccess');
        Route::any('/insDelete/{id}', 'InstituteController@insDelete')->name('insDelete');
        Route::any('/insStatus/{id}', 'InstituteController@insStatus')->name('insStatus');


    });

        /*****Appreance Section******/
    Route::group(['prefix'=>'appreance'], function(){
        Route::any('/slider', 'AppreanceController@index')->name('slider');
        Route::any('/add-new-slider/{id?}', 'AppreanceController@addnewslider')->name('add-new-slider');
        Route::any('/sliderProccess', 'AppreanceController@sliderProccess')->name('sliderProccess');
        Route::any('/sliderDelete/{id}', 'AppreanceController@sliderDelete')->name('sliderDelete');
        Route::any('/sliderStatus/{id}', 'AppreanceController@sliderStatus')->name('sliderStatus');

    });

        /****Ebook & Notes section*****/

 Route::group(['prefix'=>'ebook&notes'], function(){
    Route::any('/all-product', 'CsproductController@index')->name('all-product');
    Route::any('/add-new-product/{id?}', 'CsproductController@addnewproduct')->name('add-new-product');
    Route::any('/product-category/{id?}', 'CsproductController@productcat')->name('product-category');
    Route::any('/productCategoryProccess', 'CsproductController@productCategoryProccess')->name('productCategoryProccess');
    Route::any('/changeStatusProjectCategory/{id}', 'CsproductController@changeStatusProjectCategory')->name('changeStatusProjectCategory');
    Route::any('/deleteProductCategory/{id}', 'CsproductController@deleteProductCategory')->name('deleteProductCategory');
    Route::any('/productProccess', 'CsproductController@productProccess')->name('productProccess');
    Route::any('/productStatus/{id}', 'CsproductController@productStatus')->name('productStatus');
    Route::any('/productDelete/{id}', 'CsproductController@productDelete')->name('productDelete');


});
    /*******************/



    
    /*******************/
    });
});