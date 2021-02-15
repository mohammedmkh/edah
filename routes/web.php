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
Route::get('/', 'LicenseController@home');
Route::get('/login', 'LicenseController@viewAdminLogin')->name('login');
Route::post('saveEnvData', 'AdminController@saveEnvData');
Route::post('saveAdminData', 'AdminController@saveAdminData');
Route::get('/payment-confirm', 'AdminController@payment_confirm'); 
Route::post('/owner_login', 'LicenseController@owner_login');
Route::get('/ResetPassword', 'CustomerController@ResetPassword');
Route::post('/reset_password', 'CustomerController@reset_password');
Route::post('/getDeviceToken', 'CustomerController@getDeviceToken');
Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/viewUsers', 'CustomerController@viewUsers');
    Route::get('/paytabsPayment', 'HomeController@paytabsPayment');
    Route::post('/check_payment', 'HomeController@check_payment'); 
    Route::get('/customerReport', 'CustomerController@customerReport');
    Route::get('/ownerProfile', 'CustomerController@ownerProfileform');
    Route::post('/editOwnerProfile', 'CustomerController@editOwnerProfile');
    Route::post('/changeOwnerPassword', 'CustomerController@changeOwnerPassword');   
    Route::post('/changeGroceryOrderStatus', 'GroceryOrderController@changeGroceryOrderStatus');
    Route::get('/accept-grocery-order/{id}', 'GroceryOrderController@accpetOrder');
    Route::get('/reject-grocery-order/{id}', 'GroceryOrderController@rejectOrder');
    Route::get('/viewGroceryOrder/{id}', 'GroceryOrderController@viewsingleOrder');
    Route::get('/groceryOrderInvoice/{id}', 'GroceryOrderController@orderInvoice');
    Route::get('/printGroceryInvoice/{id}', 'GroceryOrderController@printGroceryInvoice');
    Route::get('/shopReview/{shop_id}', 'GroceryReviewController@shopReviews');
    Route::get('/notifications', 'CustomerController@viewNotifications');
    Route::get('/changeLanguage/{locale}', 'CustomerController@changeLanguage');
    Route::get('/groceryRevenueReport', 'GroceryOrderController@groceryRevenueReport');
    Route::post('/groceryRevenueFilter', 'CustomerController@groceryRevenueFilter');
    Route::get('/shopCategory/{shop_id}', 'GroceryShopController@shopCategory');
    Route::get('/itemSubcategory/{category_id}', 'GroceryShopController@itemSubcategory');    
    
    Route::resources([
        'Category' => 'CategoryController',       
        'GrocerySubCategory' => 'GrocerySubCategoryController',
        'GroceryShop'=>'GroceryShopController',
        'GroceryItem' => 'GroceryItemController',
        'GroceryOrder' => 'GroceryOrderController',
        'Item' => 'ItemController',
        'ShopOrder' => 'OrderController',
        'Shop' => 'ShopController',
        'Gallery' => 'GalleryController',
        'GroceryCoupon' => 'GroceryCouponController',
        'OwnerSetting' => 'OwnerSettingController',
        'additionalsettings' => 'AdditionalsettingController',
        'cities' => 'CitiesController',
        'countries' => 'CountriesController',
        'documents' => 'DocumentsController',
    ]);
});

Route::group(['middleware' => 'auth'], function () {       
    Route::post('/saveWebNotificationSettings', 'CompanySettingController@saveWebNotificationSettings');
    Route::get('/shopOwners', 'CustomerController@shopOwners');
    Route::get('/deliveryGuys', 'CustomerController@deliveryGuys');
    Route::get('/techusers', 'CustomerController@deliveryGuys');
    Route::get('/storeusers', 'CustomerController@storeUsers');

    Route::post('/savePaymentSetting', 'CompanySettingController@savePaymentSetting');
    Route::post('/savePointSettings', 'CompanySettingController@savePointSettings');
    Route::post('/saveLicense', 'LicenseController@saveLicenseSettings');    
    Route::post('/saveNotificationSettings', 'CompanySettingController@saveNotificationSettings');
    Route::post('/saveMailSettings', 'CompanySettingController@saveMailSettings');
    Route::post('/saveSMSSettings', 'CompanySettingController@saveSMSSettings');
    Route::post('/saveSettings', 'CompanySettingController@saveSettings');
    Route::get('/changeLanguage/{locale}', 'CustomerController@changeLanguage');
    Route::post('/saveMapSettings', 'CompanySettingController@saveMapSettings');
    Route::post('/saveCommissionSettings', 'CompanySettingController@saveCommissionSettings');
    Route::post('/saveVerificationSettings', 'CompanySettingController@saveVerificationSettings');
    Route::post('/addDriver', 'CustomerController@addDriver');
    Route::post('/addStoreUser', 'CustomerController@addStore');

    Route::get('/Delivery-guy/create', 'CustomerController@addDeliveryBoy');
    Route::get('/technicians/create', 'CustomerController@addDeliveryBoy');
    Route::get('/storeuser/create', 'CustomerController@addOwner');
    Route::get('/Driver/edit/{id}', 'CustomerController@editDriver');
    Route::post('/updateDriver/{id}', 'CustomerController@updateDriver');
    Route::post('/assignRadius', 'CustomerController@assignRadius');
    Route::get('/Customer/gallery/{id}', 'CustomerController@userGallery');
    Route::post('/savePermission', 'RoleController@savePermission');
    Route::get('/add_notification', 'CustomerController@add_notification');
    Route::get('/module', 'CustomerController@module');
    Route::get('/addCoupons', 'CustomerController@addCoupons');
    Route::post('/changelangStatus', 'LanguageController@changelangStatus');
    // grocery
   
    Route::resources([
        'Location' => 'LocationController',
        'Role' => 'RoleController',
        'Permission' => 'PermissionController',
        'AdminCategory' => 'CategoryController',
        'AdminItem' => 'ItemController',
        'AdminShop' => 'ShopController',
        'Customer' => 'CustomerController',
        'Order' => 'OrderController',
        'adminSetting' => 'CompanySettingController',
        'Language' => 'LanguageController',
        // 'NotificationTemplate' => 'NotificationTemplateController',
        'GroceryCategory'=> 'CategoryController',
        'Banner' => 'BannerController',
        'Banner' => 'BannerController',
    ]);
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('NotificationTemplate', 'NotificationTemplateController');
    Route::post('/sendTestMail', 'NotificationTemplateController@sendTestMail');
});
Route::group(['middleware' => ['auth']], function () {
    Route::resource('Coupon', 'CouponController');
});
