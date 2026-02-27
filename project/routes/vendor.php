<?php

use Illuminate\Support\Facades\Route;
// ************************************ VENDOR SECTION **********************************************

Route::prefix('vendor')->group(function () {

    Route::group(['middleware' => 'vendor'], function () {

        // VENDOR DASHBOARD

        Route::get('/dashboard', 'Vendor\VendorController@index')->name('vendor.dashboard');

        //------------ ORDER SECTION ------------

        Route::get('/orders/datatables', 'Vendor\OrderController@datatables')->name('vendor-order-datatables');
        Route::get('/orders', 'Vendor\OrderController@index')->name('vendor-order-index');
        Route::get('/order/{id}/show', 'Vendor\OrderController@show')->name('vendor-order-show');
        Route::get('/order/{id}/invoice', 'Vendor\OrderController@invoice')->name('vendor-order-invoice');
        Route::get('/order/{id}/print', 'Vendor\OrderController@printpage')->name('vendor-order-print');
        Route::get('/order/{id1}/status/{status}', 'Vendor\OrderController@status')->name('vendor-order-status');
        Route::post('/order/email/', 'Vendor\OrderController@emailsub')->name('vendor-order-emailsub');
        Route::post('/order/{slug}/license', 'Vendor\OrderController@license')->name('vendor-order-license');

        //------------ ORDER SECTION ENDS------------

        Route::get('delivery/datatables', 'Vendor\DeliveryController@datatables')->name('vendor-delivery-order-datatables');
        Route::get('delivery', 'Vendor\DeliveryController@index')->name('vendor.delivery.index');
        Route::get('delivery/boy/find', 'Vendor\DeliveryController@findReider')->name('vendor.find.rider');
        Route::post('rider/search/submit', 'Vendor\DeliveryController@findReiderSubmit')->name('vendor-rider-search-submit');

        //------------ SUBCATEGORY SECTION ------------

        Route::get('/load/subcategories/{id}/', 'Vendor\VendorController@subcatload')->name('vendor-subcat-load'); //JSON REQUEST

        //------------ SUBCATEGORY SECTION ENDS------------

        //------------ CHILDCATEGORY SECTION ------------

        Route::get('/load/childcategories/{id}/', 'Vendor\VendorController@childcatload')->name('vendor-childcat-load'); //JSON REQUEST

        //------------ CHILDCATEGORY SECTION ENDS------------

        //------------ PRODUCT SECTION ------------

        Route::get('/vendor/products/datatables', 'Vendor\ProductController@datatables')->name('vendor-prod-datatables'); //JSON REQUEST
        Route::get('/products', 'Vendor\ProductController@index')->name('vendor-prod-index');

        Route::post('/products/upload/update/{id}', 'Vendor\ProductController@uploadUpdate')->name('vendor-prod-upload-update');

        // CREATE SECTION
        Route::get('/products/types', 'Vendor\ProductController@types')->name('vendor-prod-types');
        Route::get('/products/{slug}/create', 'Vendor\ProductController@create')->name('vendor-prod-create');
        Route::post('/products/store', 'Vendor\ProductController@store')->name('vendor-prod-store');
        Route::get('/getattributes', 'Vendor\ProductController@getAttributes')->name('vendor-prod-getattributes');
        Route::get('/products/import', 'Vendor\ProductController@import')->name('vendor-prod-import');
        Route::post('/products/import-submit', 'Vendor\ProductController@importSubmit')->name('vendor-prod-importsubmit');

        Route::get('/products/catalog/datatables', 'Vendor\ProductController@catalogdatatables')->name('admin-vendor-catalog-datatables');
        Route::get('/products/catalogs', 'Vendor\ProductController@catalogs')->name('admin-vendor-catalog-index');

        // CREATE SECTION

        // EDIT SECTION
        Route::get('/products/edit/{id}', 'Vendor\ProductController@edit')->name('vendor-prod-edit');
        Route::post('/products/edit/{id}', 'Vendor\ProductController@update')->name('vendor-prod-update');

        Route::get('/products/catalog/{id}', 'Vendor\ProductController@catalogedit')->name('vendor-prod-catalog-edit');
        Route::post('/products/catalog/{id}', 'Vendor\ProductController@catalogupdate')->name('vendor-prod-catalog-update');

        // EDIT SECTION ENDS

        // IMPORT SECTION

        Route::get('/products/import/create-product', 'Vendor\ImportController@createImport')->name('vendor-import-create');
        Route::get('/products/import/edit/{id}', 'Vendor\ImportController@edit')->name('vendor-import-edit');
        Route::get('/products/import/csv', 'Vendor\ImportController@importCSV')->name('vendor-import-csv');
        Route::get('/products/import/datatables', 'Vendor\ImportController@datatables')->name('vendor-import-datatables');
        Route::get('/products/import/index', 'Vendor\ImportController@index')->name('vendor-import-index');
        Route::post('/products/import/store', 'Vendor\ImportController@store')->name('vendor-import-store');
        Route::post('/products/import/update/{id}', 'Vendor\ImportController@update')->name('vendor-import-update');
        Route::post('/products/import/csv/store', 'Vendor\ImportController@importStore')->name('vendor-import-csv-store');

        // IMPORT SECTION

        // STATUS SECTION
        Route::get('/products/status/{id1}/{id2}', 'Vendor\ProductController@status')->name('vendor-prod-status');
        // STATUS SECTION ENDS

        // DELETE SECTION
        Route::delete('/products/delete/{id}', 'Vendor\ProductController@destroy')->name('vendor-prod-delete');
        // DELETE SECTION ENDS

        //------------ VENDOR PRODUCT SECTION ENDS------------

        //------------ VENDOR GALLERY SECTION ------------

        Route::get('/gallery/show', 'Vendor\GalleryController@show')->name('vendor-gallery-show');
        Route::post('/gallery/store', 'Vendor\GalleryController@store')->name('vendor-gallery-store');
        Route::get('/gallery/delete', 'Vendor\GalleryController@destroy')->name('vendor-gallery-delete');

        //------------ VENDOR GALLERY SECTION ENDS------------

        //------------ ADMIN SHIPPING ------------

        Route::get('/shipping/datatables', 'Vendor\ShippingController@datatables')->name('vendor-shipping-datatables');
        Route::get('/shipping', 'Vendor\ShippingController@index')->name('vendor-shipping-index');
        Route::get('/shipping/create', 'Vendor\ShippingController@create')->name('vendor-shipping-create');
        Route::post('/shipping/create', 'Vendor\ShippingController@store')->name('vendor-shipping-store');
        Route::get('/shipping/edit/{id}', 'Vendor\ShippingController@edit')->name('vendor-shipping-edit');
        Route::post('/shipping/edit/{id}', 'Vendor\ShippingController@update')->name('vendor-shipping-update');
        Route::delete('/shipping/delete/{id}', 'Vendor\ShippingController@destroy')->name('vendor-shipping-delete');

        //------------ ADMIN SHIPPING ENDS ------------

        //------------ ADMIN PACKAGE ------------

        Route::get('/package/datatables', 'Vendor\PackageController@datatables')->name('vendor-package-datatables');
        Route::get('/package', 'Vendor\PackageController@index')->name('vendor-package-index');
        Route::get('/package/create', 'Vendor\PackageController@create')->name('vendor-package-create');
        Route::post('/package/create', 'Vendor\PackageController@store')->name('vendor-package-store');
        Route::get('/package/edit/{id}', 'Vendor\PackageController@edit')->name('vendor-package-edit');
        Route::post('/package/edit/{id}', 'Vendor\PackageController@update')->name('vendor-package-update');
        Route::delete('/package/delete/{id}', 'Vendor\PackageController@destroy')->name('vendor-package-delete');

        //------------ ADMIN PACKAGE ENDS------------

        //------------ VENDOR NOTIFICATION SECTION ------------

        Route::get('/order/notf/show/{id}', 'Vendor\NotificationController@order_notf_show')->name('vendor-order-notf-show');
        Route::get('/order/notf/count/{id}', 'Vendor\NotificationController@order_notf_count')->name('vendor-order-notf-count');
        Route::get('/order/notf/clear/{id}', 'Vendor\NotificationController@order_notf_clear')->name('vendor-order-notf-clear');

        //------------ VENDOR NOTIFICATION SECTION ENDS ------------

        // Vendor Profile
        Route::get('/profile', 'Vendor\VendorController@profile')->name('vendor-profile');
        Route::post('/profile', 'Vendor\VendorController@profileupdate')->name('vendor-profile-update');
        // Vendor Profile Ends

        // Vendor Shipping Cost
        Route::get('/banner', 'Vendor\VendorController@banner')->name('vendor-banner');

        // Vendor Social
        Route::get('/social', 'Vendor\VendorController@social')->name('vendor-social-index');
        Route::post('/social/update', 'Vendor\VendorController@socialupdate')->name('vendor-social-update');

        Route::get('/withdraw/datatables', 'Vendor\WithdrawController@datatables')->name('vendor-wt-datatables');
        Route::get('/withdraw', 'Vendor\WithdrawController@index')->name('vendor-wt-index');
        Route::get('/withdraw/create', 'Vendor\WithdrawController@create')->name('vendor-wt-create');
        Route::post('/withdraw/create', 'Vendor\WithdrawController@store')->name('vendor-wt-store');

        //------------ VENDOR SERVICE ------------

        Route::get('/service/datatables', 'Vendor\ServiceController@datatables')->name('vendor-service-datatables');
        Route::get('/service', 'Vendor\ServiceController@index')->name('vendor-service-index');
        Route::get('/service/create', 'Vendor\ServiceController@create')->name('vendor-service-create');
        Route::post('/service/create', 'Vendor\ServiceController@store')->name('vendor-service-store');
        Route::get('/service/edit/{id}', 'Vendor\ServiceController@edit')->name('vendor-service-edit');
        Route::post('/service/edit/{id}', 'Vendor\ServiceController@update')->name('vendor-service-update');
        Route::delete('/service/delete/{id}', 'Vendor\ServiceController@destroy')->name('vendor-service-delete');

        //------------ VENDOR SERVICE ENDS ------------

        //------------ VENDOR PICKUP POINT ------------
        Route::get('/pickup-point/datatables', 'Vendor\PickupPointController@datatables')->name('vendor-pickup-point-datatables');
        Route::get('/pickup-point', 'Vendor\PickupPointController@index')->name('vendor-pickup-point-index');
        Route::get('/pickup-point/create', 'Vendor\PickupPointController@create')->name('vendor-pickup-point-create');
        Route::post('/pickup-point/create', 'Vendor\PickupPointController@store')->name('vendor-pickup-point-store');
        Route::get('/pickup-point/edit/{id}', 'Vendor\PickupPointController@edit')->name('vendor-pickup-point-edit');
        Route::post('/pickup-point/edit/{id}', 'Vendor\PickupPointController@update')->name('vendor-pickup-point-update');
        Route::delete('/pickup-point/delete/{id}', 'Vendor\PickupPointController@destroy')->name('vendor-pickup-point-delete');
        Route::get('/pickup-point/status/{id}/{status}', 'Vendor\PickupPointController@status')->name('vendor-pickup-point-status');

        //------------ VENDOR PICKUP POINT END ------------

        //------------ VENDOR SOCIAL LINK ------------

        Route::get('/social-link/datatables', 'Vendor\SocialLinkController@datatables')->name('vendor-sociallink-datatables'); //JSON REQUEST
        Route::get('/social-link', 'Vendor\SocialLinkController@index')->name('vendor-sociallink-index');
        Route::get('/social-link/create', 'Vendor\SocialLinkController@create')->name('vendor-sociallink-create');
        Route::post('/social-link/create', 'Vendor\SocialLinkController@store')->name('vendor-sociallink-store');
        Route::get('/social-link/edit/{id}', 'Vendor\SocialLinkController@edit')->name('vendor-sociallink-edit');
        Route::post('/social-link/edit/{id}', 'Vendor\SocialLinkController@update')->name('vendor-sociallink-update');
        Route::delete('/social-link/delete/{id}', 'Vendor\SocialLinkController@destroy')->name('vendor-sociallink-delete');
        Route::get('/social-link/status/{id1}/{id2}', 'Vendor\SocialLinkController@status')->name('vendor-sociallink-status');

        //------------ VENDOR SOCIAL LINK ENDS ------------
        // -------------------------- Vendor Income ------------------------------------//
        Route::get('earning/datatables', "Vendor\IncomeController@datatables")->name('vendor.income.datatables');
        Route::get('total/earning', "Vendor\IncomeController@index")->name('vendor.income');

        Route::get('/verify', 'Vendor\VendorController@verify')->name('vendor-verify');
        Route::get('/warning/verify/{id}', 'Vendor\VendorController@warningVerify')->name('vendor-warning');
        Route::post('/verify', 'Vendor\VendorController@verifysubmit')->name('vendor-verify-submit');
    });
});

    // ************************************ VENDOR SECTION ENDS**********************************************
