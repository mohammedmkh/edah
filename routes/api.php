<?php

use Illuminate\Http\Request;



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

    Route::get('getCustomerQuestions', 'UsersApiController@getCustomerQuestions');

    Route::get('getTechnicalQuestions', 'UsersApiController@getTechnicalQuestions');

    Route::post('uploadFile', 'UsersApiController@uploadFile');

    Route::post('uploadImage', 'UsersApiController@uploadImage');

    Route::post('setCustomerAnswers', 'UsersApiController@setUserAnswers');

    Route::post('setOrderStatusHistory', 'UsersApiController@setOrderStatusHistory');

    Route::post('registerTechnician', 'UsersApiController@registerTechnician');

    Route::post('registerStore', 'UsersApiController@registerStore');

    Route::post('getTechnicanAvilable', 'UsersApiController@getTechnicanAvilable');

    Route::post('getSupplierAvilable', 'UsersApiController@getSupplierAvilable');

    Route::post('setTechnicalEvaluation', 'UsersApiController@setTechnicalEvaluation');

    Route::post('setUserEvaluation', 'UsersApiController@setUserEvaluation');

    Route::get('getOrderStatus', 'UsersApiController@getOrderStatus');


    Route::post('login', 'UsersApiController@loginSupplier');


});


Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1', 'middleware' => ['auth:api', 'apiLang']], function () {
    // Permissions

    Route::get('getcheckoutid', 'UsersApiController@payTesCheckoutid');

    Route::get('myInfo', 'UsersApiController@myInfo');
    Route::post('edituser', 'UsersApiController@editUser');

    Route::get('logout', 'UsersApiController@logout');

    Route::post('confirmnewphone', 'UsersApiController@confirmnewphone');

    Route::post('addordernew', 'OrdersApiController@addOrder');

    Route::post('vehiclerate', 'VehicleApiController@vehicleRate');

    Route::post('setTechnicianLocation', 'UsersApiController@setTechnicianLocation');


    Route::post('setTechnicalAnswers', 'UsersApiController@setUserAnswers');
    Route::post('setSupplierPriceOffer', 'UsersApiController@setSupplierPriceOffer');
    Route::post('selectTechAndCheckout', 'UsersApiController@selectTechAndCheckout');


    Route::post('acceptOrderOrDeny', 'UsersApiController@acceptOrderOrDeny');


    Route::get('getOrdersNotEnd', 'UsersApiController@getOrdersNotEnd');
    Route::get('getOrders', 'UsersApiController@getOrders');

    Route::get('getOrders/{id}', 'UsersApiController@getOrders');

    Route::post('updateProfile', 'UsersApiController@updateProfile');

    Route::post('searchStoreByName', 'UsersApiController@searchStoreByName');
    Route::post('searchStores', 'UsersApiController@searchStores');

    Route::post('addRequestToStore', 'UsersApiController@addRequestToStore');


    Route::get('getNotifications' , 'UsersApiController@getNotifications');
    Route::post('readNotification' , 'UsersApiController@readNotification');
    Route::post('readAllNotification' , 'UsersApiController@readAllNotification');


    Route::post('getRequestToStore' , 'UsersApiController@getRequestToStore');


});





