<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create sometshing great!
|
 */

Auth::routes();
Route::get('/', 'WebController@home');
Route::get('/login', 'WebController@viewAdminLogin')->name('login');

Route::post('/owner_login', 'WebController@owner_login');
Route::get('/ResetPassword', 'CustomerController@ResetPassword');
Route::post('/reset_password', 'CustomerController@reset_password');
//Route::post('/getDeviceToken', 'CustomerController@getDeviceToken');


Route::group(['prefix' => adminPath() , 'middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/viewUsers', 'CustomerController@viewUsers');
    Route::get('/customerReport', 'CustomerController@customerReport');
    Route::get('/ownerProfile', 'CustomerController@ownerProfileform');
    Route::post('/editOwnerProfile', 'CustomerController@editOwnerProfile');
    Route::post('/changeOwnerPassword', 'CustomerController@changeOwnerPassword');
    Route::get('/viewOrder/{id}', 'OrderController@viewsingleOrder');
    Route::get('/notifications', 'CustomerController@viewNotifications');
    Route::get('/changeLanguage/{locale}', 'CustomerController@changeLanguage');
    Route::get('/itemSubcategory/{category_id}', 'GroceryShopController@itemSubcategory');

    Route::get('/techniciansList', 'CustomerController@techniciansList')->name('techniciansList');
    Route::get('/storeList', 'CustomerController@storeList')->name('storeList');

    Route::get('/adminusers', 'CustomerController@adminUsers');
    Route::get('/techusers', 'CustomerController@techUsers');
    Route::get('/storeusers', 'CustomerController@storeUsers');
    Route::get('/technicians/create', 'CustomerController@addTechnicianPage');
    Route::get('/storeuser/create', 'CustomerController@addStoreUser');
    Route::get('/adminuser/create', 'CustomerController@addAdminUser');

    Route::get('/tech/edit/{id}', 'CustomerController@editTech');

    Route::post('/addTechnician', 'CustomerController@addTechnician');
    Route::post('/addAdmin', 'CustomerController@addAdmin');

    Route::get('/ordersList', 'OrderController@ordersList')->name('ordersList');
    Route::get('/couponsList', 'CouponController@couponsList')->name('couponsList');
    Route::get('/categoryList', 'CategoryController@categoryList')->name('categoryList');
    Route::get('/subCategoryList', 'SubCategoryController@subCategoryList')->name('subCategoryList');
    Route::get('/customerList', 'CustomerController@customerList')->name('customerList');
    Route::get('/adminList', 'CustomerController@adminList')->name('adminList');
    Route::get('/adminList', 'CustomerController@adminList')->name('adminList');
    Route::get('/technicalAccountStatmentPage/{id}', 'CustomerController@technicalAccountStatmentPage');
    Route::get('/technicalAccountStatment', 'CustomerController@technicalAccountStatment')->name("technicalAccountStatment");



    Route::resources([
        'Category' => 'CategoryController',
        'SubCategory' => 'SubCategoryController',
        'Customer' => 'CustomerController',
        'Order' => 'OrderController',
        'Coupon' => 'CouponController',
        'OwnerSetting' => 'OwnerSettingController',
        'additionalsettings' => 'AdditionalsettingController',
        'cities' => 'CitiesController',
        'countries' => 'CountriesController',
        'documents' => 'DocumentsController',
        'adminSetting' => 'CompanySettingController',
        'notifications' => 'NotificationController',
    ]);
});



Route::group(['middleware' => 'auth'], function () {
    Route::resource('NotificationTemplate', 'NotificationTemplateController');
    Route::post('/sendTestMail', 'NotificationTemplateController@sendTestMail');
});
Route::group(['middleware' => ['auth']], function () {
    Route::resource('Coupon', 'CouponController');
});
