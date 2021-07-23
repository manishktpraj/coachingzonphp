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

Route::get('/', function () {
    return view('welcome');
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
        /******Question Section*******/
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('/logout', 'LoginController@logout')->name('adminLogout');
        Route::get('/all-question', 'QuestionController@index')->name('all-question');
        Route::get('/add-new-question', 'QuestionController@addNewQuestion')->name('add-new-question');
        Route::get('/question-subjects', 'QuestionController@questionSubjects')->name('question-subjects');
        Route::any('/subjectProccess', 'QuestionController@subjectProccess')->name('subjectProccess');
        Route::any('/changeStatusQCategory/{id}', 'QuestionController@changeStatusQCategory')->name('changeStatusQCategory');
        Route::any('/editsubject/{id}', 'QuestionController@questionSubjects')->name('editsubject');
        Route::any('/deletesubject/{id}', 'QuestionController@deletesubject')->name('deletesubject');
        Route::any('/bulkActionsSubject', 'QuestionController@bulkActionsSubject')->name('bulkActionsSubject');
        Route::get('/exportQuestion', 'QuestionController@exportQuestion')->name('exportQuestion');
        Route::get('/importQuestion', 'QuestionController@importQuestion')->name('importQuestion');

        
        /******Tests/Exams Section*******/
        Route::any('/tests', 'TestsController@index')->name('tests');
        Route::get('/addnew/{id?}', 'TestsController@addNewTest')->name('addnewtest');
        Route::any('/testProccess', 'TestsController@testProccess')->name('testProccess');
        Route::any('/testStatus/{id}', 'TestsController@testStatus')->name('testStatus');
        Route::any('/testDelete/{id}', 'TestsController@testDelete')->name('testDelete');
        Route::get('/test-category/{id?}', 'TestsController@testCategory')->name('test-category');
        Route::any('/testCategoryProccess', 'TestsController@testCategoryProccess')->name('testCategoryProccess');
        Route::any('/changeStatusTCategory/{id}', 'TestsController@changeStatusTCategory')->name('changeStatusTCategory');
        Route::any('/testCatDelete/{id}', 'TestsController@testCatDelete')->name('testCatDelete');
        Route::any('/bulkActionTest', 'TestsController@bulkActionTest')->name('bulkActionTest');
        Route::any('/bulkActionTestCat', 'TestsController@bulkActionTestCat')->name('bulkActionTestCat');
        
        
        
        
        /******Videos Section*******/
        Route::any('/all-videos', 'VideosController@index')->name('all-videos');
        Route::get('/add-new-video/{id?}', 'VideosController@addNewVideo')->name('add-new-video');
        Route::any('/videoProccess', 'VideosController@videoProccess')->name('videoProccess');
        Route::any('/videoStatus/{id}', 'VideosController@videoStatus')->name('videoStatus');
        Route::any('/videoDelete/{id}', 'VideosController@videoDelete')->name('videoDelete');
        Route::any('/bulkAction', 'VideosController@bulkAction')->name('bulkAction');
        Route::get('/video-category/{id?}', 'VideosController@videoCategory')->name('video-category');
        Route::any('/videoCategoryProccess', 'VideosController@videoCategoryProccess')->name('videoCategoryProccess');
        Route::any('/changeStatusVCategory/{id}', 'VideosController@changeStatusVCategory')->name('changeStatusVCategory');
        Route::any('/deleteVCategory/{id}', 'VideosController@deleteVCategory')->name('deleteVCategory');
        Route::any('/bulkActionVideoCat', 'VideosController@bulkActionVideoCat')->name('bulkActionVideoCat');
       
       
       
        /******Study Material Section*******/
        Route::any('/all-study-material', 'StudyController@index')->name('all-study-material');
        Route::get('/add-new-study/{id?}', 'StudyController@addNewStudy')->name('add-new-study');
        Route::get('/study-category/{id?}', 'StudyController@studyCategory')->name('study-category');
        Route::any('/studyCategoryProccess', 'StudyController@studyCategoryProccess')->name('studyCategoryProccess');
        Route::any('/deletescategory/{id}', 'StudyController@deleteCategory')->name('deleteCategory');
        Route::any('/changestatuscategory/{id}', 'StudyController@changeStatusCategory')->name('changeStatusCategory');
        Route::any('/bulkActionSM', 'StudyController@bulkActionSM')->name('bulkActionSM');
        Route::any('/studyMaterialProccess', 'StudyController@studyMaterialProccess')->name('studyMaterialProccess');
        Route::any('/studyMaterialDelete/{id}', 'StudyController@studyMaterialDelete')->name('studyMaterialDelete');
        Route::any('/studyMaterialStatus/{id}', 'StudyController@studyMaterialStatus')->name('studyMaterialStatus');
        Route::any('/bulkActionsmCat', 'StudyController@bulkActionsmCat')->name('bulkActionsmCat');
        
        /******Students Section*******/
        Route::any('/all-students', 'StudentsController@index')->name('all-students');
        Route::get('/add-new-student/{id?}', 'StudentsController@addNewStudent')->name('add-new-student');
        Route::get('/student-group/{id?}', 'StudentsController@studentGroup')->name('student-group');
        Route::any('/studentStatus/{id}', 'StudentsController@studentStatus')->name('studentStatus');
        Route::any('/studentProccess', 'StudentsController@studentProccess')->name('studentProccess');
        Route::any('/studentDelete/{id}', 'StudentsController@studentDelete')->name('studentDelete');
        Route::any('/viewstudent/{id}', 'StudentsController@viewstudent')->name('viewstudent');
        Route::any('/changeStatusgroupCategory/{id}', 'StudentsController@changeStatusgroupCategory')->name('changeStatusgroupCategory');
        Route::any('/groupProccess', 'StudentsController@groupProccess')->name('groupProccess');
        Route::any('/deletegroup/{id}', 'StudentsController@deletegroup')->name('deletegroup');
        
        /******Packages Section*******/
        Route::any('/all-packages', 'PackagesController@index')->name('all-packages');
        Route::get('/add-new-package/{id?}', 'PackagesController@addNewPackage')->name('add-new-package');
        Route::any('/packageDelete/{id}', 'PackagesController@packageDelete')->name('packageDelete');
        Route::any('/packageManage/{id}', 'PackagesController@packageManage')->name('packageManage');
        Route::any('/packageStatus/{id}', 'PackagesController@packageStatus')->name('packageStatus');
        Route::any('/packageProccess', 'PackagesController@packageProccess')->name('packageProccess');
        Route::get('/package-category/{id?}', 'PackagesController@categoryPackage')->name('package-category');
        Route::any('/packageCategoryProccess', 'PackagesController@packageCategoryProccess')->name('packageCategoryProccess');
        Route::any('/changeStatusPCategory/{id}','PackagesController@changeStatusPCategory')->name('changeStatusPCategory');
        Route::any('/deletepcategory/{id}', 'PackagesController@deletepcategory')->name('deletepcategory');
        
        
        /******Offers & Promos Section*******/
        Route::any('/offers-promos', 'OffersController@index')->name('offers-promos');
        Route::any('/add-new-offers/{id?}', 'OffersController@alloffersShow')->name('add-new-offers');
        Route::any('/offerprocess', 'OffersController@offerprocessrequest')->name('offerprocess');
        Route::any('/deleteoffer/{id}', 'OffersController@deleteoffer')->name('deleteoffer');
        Route::any('/offersStatus/{id}', 'OffersController@offersStatus')->name('offersStatus');
        
        /******Orders Section*******/
        Route::get('/order', 'OrderController@index')->name('order');
      
      /******Faculty Section*******/
        Route::any('/faculty', 'FacultyController@index')->name('faculty');
        Route::any('/add-new-faculty/{id?}', 'FacultyController@addNewFaculty')->name('add-new-faculty');
        Route::any('/facultyStatus/{id}', 'FacultyController@facultyStatus')->name('facultyStatus');
        Route::any('/facultyProccess', 'FacultyController@facultyProccess')->name('facultyProccess');
        Route::any('/facultyDelete/{id}', 'FacultyController@facultyDelete')->name('facultyDelete');
      
        /******Reports Section*******/
        Route::get('/reports', 'ReportsController@index')->name('reports');
        
        
        /******Payments Section*******/
        Route::get('/payments', 'PaymentsController@index')->name('payments');
        
        
        /******Settings Section*******/
        Route::get('/store-setting', 'SettingsController@index')->name('store-setting');
        Route::get('/account-setting', 'SettingsController@accountSetting')->name('account-setting');
        Route::any('/accountProccess', 'SettingsController@accountProccess')->name('accountProccess');
        Route::any('/passProccess', 'SettingsController@passProccess')->name('passProccess');
        Route::any('/getcityajax', 'SettingsController@getcityajax')->name('getcityajax');
        Route::any('/storeProccess', 'SettingsController@storeProccess')->name('storeProccess');
    /*******************/
    /*******************/
    });
});