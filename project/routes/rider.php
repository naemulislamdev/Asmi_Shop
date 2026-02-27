<?php

use Illuminate\Support\Facades\Route;

// ************************************ RIDER SECTION ENDS**********************************************
Route::prefix('rider')->group(function () {

    // USER AUTH SECION
    Route::get('/login', 'Rider\LoginController@showLoginForm')->name('rider.login');
    Route::post('/login', 'Auth\Rider\LoginController@login')->name('rider.login.submit');
    Route::get('/success/{status}', 'Rider\LoginController@status')->name('rider.success');

    Route::get('/register', 'Rider\RegisterController@showRegisterForm')->name('rider.register');

    // rider Register
    Route::post('/register', 'Auth\Rider\RegisterController@register')->name('rider-register-submit');
    Route::get('/register/verify/{token}', 'Auth\Rider\RegisterController@token')->name('rider-register-token');
    // rider Register End

    //------------ rider FORGOT SECTION ------------
    Route::get('/forgot', 'Auth\Rider\ForgotController@index')->name('rider.forgot');
    Route::post('/forgot', 'Auth\Rider\ForgotController@forgot')->name('rider.forgot.submit');
    Route::get('/change-password/{token}', 'Auth\Rider\ForgotController@showChangePassForm')->name('rider.change.token');
    Route::post('/change-password', 'Auth\Rider\ForgotController@changepass')->name('rider.change.password');

    //------------ USER FORGOT SECTION ENDS ------------

    Route::get('/logout', 'Rider\LoginController@logout')->name('rider-logout');
    Route::get('/dashboard', 'Rider\RiderController@index')->name('rider-dashboard');

    Route::get('/profile', 'Rider\RiderController@profile')->name('rider-profile');
    Route::post('/profile', 'Rider\RiderController@profileupdate')->name('rider-profile-update');

    Route::get('/service/area', 'Rider\RiderController@serviceArea')->name('rider-service-area');
    Route::get('/service/area/create', 'Rider\RiderController@serviceAreaCreate')->name('rider-service-area-create');
    Route::post('/service/area/create', 'Rider\RiderController@serviceAreaStore')->name('rider-service-area-store');
    Route::get('/service/area/edit/{id}', 'Rider\RiderController@serviceAreaEdit')->name('rider-service-area-edit');
    Route::post('/service/area/edit/{id}', 'Rider\RiderController@serviceAreaUpdate')->name('rider-service-area-update');
    Route::get('/service/area/delete/{id}', 'Rider\RiderController@serviceAreaDestroy')->name('rider-service-area-delete');

    Route::get('/withdraw', 'Rider\WithdrawController@index')->name('rider-wwt-index');
    Route::get('/withdraw/create', 'Rider\WithdrawController@create')->name('rider-wwt-create');
    Route::post('/withdraw/create', 'Rider\WithdrawController@store')->name('rider-wwt-store');

    Route::get('my/orders', 'Rider\RiderController@orders')->name('rider-orders');
    Route::get('order/details/{id}', 'Rider\RiderController@orderDetails')->name('rider-order-details');
    Route::get('order/delivery/accept/{id}', 'Rider\RiderController@orderAccept')->name('rider-order-delivery-accept');
    Route::get('order/delivery/reject/{id}', 'Rider\RiderController@orderReject')->name('rider-order-delivery-reject');
    Route::get('order/delivery/complete/{id}', 'Rider\RiderController@orderComplete')->name('rider-order-delivery-complete');

    Route::get('/reset', 'Rider\RiderController@resetform')->name('rider-reset');
    Route::post('/reset', 'Rider\RiderController@reset')->name('rider-reset-submit');
});

    // ************************************ RIDER SECTION ENDS**********************************************
