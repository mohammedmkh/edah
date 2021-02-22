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


Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1', 'middleware' => ['apiLang']], function () {


    Route::post('signPhoneClient', 'UsersApiController@signPhoneClient');
    Route::post('validationCode', 'UsersApiController@validationCode');
    Route::post('registerClient', 'UsersApiController@registerClient');
    Route::post('loginClient', 'UsersApiController@loginClient');


    Route::get('getCountries', 'DataApiController@getCountries');
    Route::get('getCitiesByCountry/{id}', 'DataApiController@getCitiesByCountry');


    //signPhoneSupplier
    Route::post('signPhoneTechnician', 'UsersApiController@signPhoneTechnician');
    Route::post('signPhoneStore', 'UsersApiController@signPhoneStore');

    Route::get('docsOfTech', 'UsersApiController@docsOfTech');

    Route::get('docsOfStore', 'UsersApiController@docsOfStore');

    Route::get('getCategories', 'UsersApiController@getCategories');

    Route::get('getSubCategories/{id}', 'UsersApiController@getSubCategories');

    Route::post('searchCategory', 'UsersApiController@searchCategory');

    Route::post('searchNearestTechnicalLocation', 'UsersApiController@searchNearestTechnicalLocation');

    Route::post('searchSubCategory', 'UsersApiController@searchSubCategory');

    Route::post('initOrder', 'UsersApiController@initOrder');

    Route::post('registerTechnician', 'UsersApiController@registerTechnician');

    Route::post('registerStore', 'UsersApiController@registerStore');

    Route::post('uploadFile', 'UsersApiController@uploadFile');


    Route::post('login', 'UsersApiController@loginSupplier');


});


Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1', 'middleware' => ['auth:api', 'apiLang']], function () {
    // Permissions

    Route::get('getcheckoutid', 'UsersApiController@payTesCheckoutid');

    Route::get('myInfo', 'UsersApiController@myInfo');
    Route::post('edituser', 'UsersApiController@editUser');
    Route::post('logout', 'UsersApiController@logout');
    Route::post('confirmnewphone', 'UsersApiController@confirmnewphone');

    Route::post('addordernew', 'OrdersApiController@addOrder');

    Route::post('vehiclerate', 'VehicleApiController@vehicleRate');

    Route::post('setTechnicianLocation', 'UsersApiController@setTechnicianLocation');


    /////// this api for captins
    ///


});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user/login', 'CustomerController@userLogin');
Route::post('/user/register', 'CustomerController@userRegister');
Route::post('/user/verifyPhone', 'CustomerController@verifyPhone');
Route::post('/user/resendOTP', 'CustomerController@resendOTP');
Route::post('/user/checkOtp', 'CustomerController@checkOtp');
Route::post('/user/forgetPassword', 'CustomerController@forgerUserPassword');
Route::post('/driver/forgetPassword', 'CustomerController@forgerUserPassword');
Route::get('/user/keySetting', 'CompanySettingController@keySetting');
Route::get('/driver/keySetting', 'CompanySettingController@keySetting');
Route::get('/user/home', 'CustomerController@userHome');
Route::get('/user/banner', 'BannerController@bannerImage');
Route::post('/driver/login', 'CustomerController@driverLogin');
Route::post('/driver/verifyPhone', 'CustomerController@verifyDriverPhone');
Route::post('/driver/register', 'CustomerController@driverRegister');
Route::post('/driver/resendOTP', 'CustomerController@resendOTP');
Route::post('/driver/checkOtp', 'CustomerController@checkDriverOtp');
// food // Route::get('/user/categoryShop/{id}','ShopController@categoryShop' );
// food // Route::get('/user/categories','CategoryController@viewCategory' );
// food // Route::get('/user/shops','ShopController@viewShop');
// food // Route::get('/user/shopDetail/{id}','ShopController@shopDetail');
// food // Route::get('/user/items/{id}','ItemController@viewShopItem' );
Route::get('/user/viewCoupon', 'CouponController@viewCoupon');
Route::get('/user/viewGroceryCoupon', 'GroceryCouponController@viewGroceryCoupon');
// food //Route::get('/user/trackOrder/{id}','OrderController@trackOrder' );
// food //Route::get('/user/driverLocation/{id}','OrderController@driverLocation' );
Route::post('/user/chkCoupon', 'CouponController@chkCoupon');
Route::get('/user/viewShopCoupon/{shop_id}', 'CouponController@viewShopCoupon');
Route::get('/user/viewGroceryShopCoupon/{shop_id}', 'GroceryCouponController@viewGroceryShopCoupon');
// food // Route::get('/user/itemReview/{id}','ReviewController@itemReview' );

Route::group(['middleware' => ['auth:api']], function () {
    // grocery
    Route::post('/user/createGroceryOrder', 'GroceryController@createGroceryOrder');
    Route::post('/user/addGroceryReview', 'GroceryController@addGroceryReview');
    Route::get('/user/groceryOrder', 'GroceryController@groceryOrder');
    Route::get('/user/singleGroceryOrder/{order_id}', 'GroceryController@singleGroceryOrder');
    Route::get('/user/trackGroceryOrder/{id}', 'GroceryController@trackOrder');
    Route::get('/user/paytabPayment/{order_id}', 'GroceryController@paytabPayment');
    Route::post('/user/deliveredProduct', 'GroceryController@deliveredProduct');
    // Route::get('/user/viewReview/{order_id}','GroceryController@ViewOrderReview' );

    Route::get('/user/viewReview', 'GroceryReviewController@viewUserReview');
    //food // Route::post('/user/addDriverReview','ReviewController@addDriverReview' );
    //food // Route::post('/user/addShopReview','ReviewController@addShopReview' );
    //food // Route::post('/user/addItemReview','ReviewController@addItemReview' );
    Route::post('/user/editProfile', 'CustomerController@userEditProfile');
    Route::post('/user/changeImage', 'CustomerController@changeImage');
    Route::post('/user/changePassword', 'CustomerController@changeUserPassword');
    //food // Route::get('/user/userOrder','OrderController@viewUserOrder' );
    //food // Route::get('/user/singleOrder/{id}','OrderController@singleOrder');
    // food // Route::post('/user/createOrder','OrderController@createOrder' );
    Route::post('/user/addBookmark', 'CustomerController@addUserBookmark');
    // food // Route::get('/user/viewFavourite','CustomerController@viewUserFavourite' );
    Route::get('/user/viewNotification', 'NotificationController@viewNotification');
    Route::get('/user/userAddress', 'CustomerController@userAllAddress');
    Route::post('/user/addAddress', 'CustomerController@addUserAddress');
    Route::post('/user/editAddress', 'CustomerController@editUserAddress');
    Route::get('/user/deleteAddress/{id}', 'CustomerController@deleteAddress');
    Route::post('/user/saveSetting', 'CustomerController@saveUserSetting');
    // food // Route::get('/user/cancelOrder/{id}','OrderController@cancelOrder' );
    Route::post('/user/addPhoto', 'CustomerController@addPhoto');
    Route::get('/user/friendsCode', 'CustomerController@friendsCode');
    Route::get('/user/getAddress/{id}', 'CustomerController@getAddress');
    Route::get('/user/setAddress/{id}', 'CustomerController@setAddress');
    Route::get('/user/userDetail', 'CustomerController@userDetail');

    Route::group(['prefix' => 'driver'], function () {

        // food// Route::post('/acceptRequest','OrderController@acceptRequest' );
        Route::get('/driverTrip', 'OrderController@driverTrip');
        Route::get('/driverReview', 'GroceryReviewController@driverReview');
        // food// Route::get('/driverRequest','OrderController@driverRequest' );
        // food// Route::get('/rejectDriverOrder/{order_id}','OrderController@rejectDriverOrder' );
        Route::get('/driverProfile', 'CustomerController@driverProfile');
        Route::get('/changeAvaliableStatus/{status}', 'CustomerController@changeAvaliableStatus');
        // food // Route::post('/driverStatus','OrderController@driverStatus' );
        // food //  Route::get('/collectPayment/{id}','OrderController@collectPayment' );
        Route::post('/editDriverProfile', 'CustomerController@editDriverProfile');
        Route::post('/driverSetting', 'CustomerController@driverSetting');
        //food // Route::post('/pickupFood','OrderController@pickupFood' );
        //food // Route::get('/viewOrder/{id}','OrderController@viewOrderDetail' );
        //food // Route::post('/driverCancelOrder','OrderController@driverCancelOrder' );
        Route::post('/earningHistroy', 'OrderController@earningHistroy');
        Route::get('/viewnotification', 'OrderController@viewnotification');
        Route::post('/saveDriverLocation', 'OrderController@saveDriverLocation');
        //  grocery orders
        Route::get('/groceryOrderRequest', 'GroceryController@groceryOrderRequest');
        Route::post('/acceptGroceryOrderRequest', 'GroceryController@acceptGroceryOrderRequest');
        Route::post('/driverGroceryStatus', 'GroceryController@driverGroceryStatus');
        Route::get('/collectGroceryPayment/{id}', 'GroceryController@collectGroceryPayment');
        Route::post('/pickupGrocery', 'GroceryController@pickupGrocery');
        Route::get('/viewGroceryOrder/{id}', 'GroceryController@viewGroceryOrderDetail');
        Route::post('/driverCancelGroceryOrder', 'GroceryController@driverCancelGroceryOrder');
        Route::get('/rejectGroceryOrder/{order_id}', 'GroceryController@rejectGroceryOrder');
        Route::post('/earningGroceryHistroy', 'GroceryController@earningGroceryHistroy');

    });
});

// grocery api

Route::get('/user/groceryCategory', 'GroceryController@groceryCategory');
Route::get('/user/grocerySubCategory/{category_id}', 'GroceryController@grocerySubCategory');
Route::get('/user/groceryShop', 'GroceryController@groceryShop');
Route::get('/user/groceryShopDetail/{shop_id}', 'GroceryController@groceryShopDetail');
Route::get('/user/groceryItem/{shop_id}', 'GroceryController@groceryItem');
Route::get('/user/groceryItemDetail/{item_id}', 'GroceryController@groceryItemDetail');
Route::get('/user/groceryShopCategory/{shop_id}', 'GroceryController@groceryShopCategory');
Route::get('/user/groceryShop/{category_id}', 'GroceryController@groceryCategoryShop');


// admin Api

Route::post('/admin/login', 'AdminApiController@ownerLogin');
Route::post('/admin/resetPassword', 'AdminApiController@resetOwnerPassword');
Route::group(['middleware' => ['auth:adminApi']], function () {
    Route::get('/admin/allShops', 'AdminApiController@allShops');
    Route::get('/admin/allItem', 'AdminApiController@allItem');
    Route::get('/admin/allCategory', 'AdminApiController@allCategory');
    Route::get('/admin/locations', 'AdminApiController@locations');
    Route::get('/admin/allSubCategory', 'AdminApiController@allSubCategory');
    Route::get('/admin/groceryCoupon', 'AdminApiController@groceryCoupon');
    Route::get('/admin/imageSlider', 'AdminApiController@imageSlider');
    Route::get('/admin/allUsers', 'AdminApiController@allUsers');
    Route::get('/admin/allDrivers', 'AdminApiController@allDrivers');
    Route::get('/admin/shopItem/{id}', 'AdminApiController@shopItem');

    Route::post('/admin/addCategory', 'AdminApiController@addCategory');
    Route::post('/admin/addSubCategory', 'AdminApiController@addSubCategory');
    Route::post('/admin/addShop', 'AdminApiController@addShop');
    Route::post('/admin/addItem', 'AdminApiController@addItem');
    Route::post('/admin/addCoupon', 'AdminApiController@addCoupon');
    Route::post('/admin/addBanner', 'AdminApiController@addBanner');
    Route::post('/admin/addLocation', 'AdminApiController@addLocation');

    Route::get('/admin/viewCategory/{id}', 'AdminApiController@viewCategory');
    Route::get('/admin/viewSubCategory/{id}', 'AdminApiController@viewSubCategory');
    Route::get('/admin/viewShop/{id}', 'AdminApiController@viewShop');
    Route::get('/admin/viewItem/{id}', 'AdminApiController@viewItem');
    Route::get('/admin/viewCoupon/{id}', 'AdminApiController@viewCoupon');
    Route::get('/admin/viewBanner/{id}', 'AdminApiController@viewBanner');
    Route::get('/admin/viewLocation/{id}', 'AdminApiController@viewLocation');

    Route::get('/admin/category/delete/{id}', 'AdminApiController@deleteCategory');
    Route::get('/admin/SubCategory/delete/{id}', 'AdminApiController@deleteSubCategory');
    Route::get('/admin/Shop/delete/{id}', 'AdminApiController@deleteShop');
    Route::get('/admin/Item/delete/{id}', 'AdminApiController@deleteItem');
    Route::get('/admin/Coupon/delete/{id}', 'AdminApiController@deleteCoupon');
    Route::get('/admin/Banner/delete/{id}', 'AdminApiController@deleteBanner');
    Route::get('/admin/Location/delete/{id}', 'AdminApiController@deleteLocation');

    Route::post('/admin/Location/edit', 'AdminApiController@editLocation');
    Route::post('/admin/Banner/edit', 'AdminApiController@editBanner');
    Route::post('/admin/Coupon/edit', 'AdminApiController@editCoupon');
    Route::post('/admin/Item/edit', 'AdminApiController@editItem');
    Route::post('/admin/Shop/edit', 'AdminApiController@editShop');
    Route::post('/admin/Category/edit', 'AdminApiController@editCategory');
    Route::post('/admin/subCategory/edit', 'AdminApiController@editsubCategory');

    Route::get('/admin/viewOrders', 'AdminApiController@viewOrders');
    Route::get('/admin/singleOrder/{order_id}', 'AdminApiController@singleOrder');
});
