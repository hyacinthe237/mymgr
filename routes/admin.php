<?php
Route::group(['prefix' => 'admin', 'namespace' => 'Views\Backend', 'as' => 'admin.'], function () {
    Route::get('/login', 'AuthController@login')->name('admin.login');
    Route::middleware('throttle:5,1')->post('/login', 'AuthController@doLogin')->name('admin.dologin');
    Route::get('/forgot', 'AuthController@forgotPassword')->name('admin.forgot');
    Route::post('/forgot', 'AuthController@sendLink')->name('admin.sendlink');
    Route::get('/reset/{token}', 'AuthController@showResetForm')->name('admin.reset');
    Route::get('/request', 'AuthController@requestPassword')->name('admin.request');

    Route::group(['middleware' => ['admin_auth', 'admin']], function () {
        Route::get('files', 'HomeController@files')->name('files');
        Route::get('logout', 'AuthController@logout')->name('logout');
        Route::get('/', 'HomeController@dashboard')->name('dashboard');

        Route::resource('pages', 'PageController');
        Route::resource('categories', 'CategoryController');

        /**
         * Bookings routes 
         */
        Route::group(['prefix' => 'bookings'], function () {
            Route::get('/', 'BookingController@index')->name('bookings');
            Route::get('/{code}', 'BookingController@show')->name('bookings.show');
        });
        
        /**
         * Documents routes 
         */
        Route::group(['prefix' => 'documents'], function () {
            Route::get('/', 'DocumentController@index')->name('documents');
        });

        /**
         * Tickets routes 
         */
        Route::group(['prefix' => 'tickets'], function () {
            Route::get('/', 'TicketController@index')->name('tickets');
            Route::get('/{code}', 'TicketController@show')->name('tickets.show');
        });

        /**
         * ACL Routes
         */
        Route::group(['prefix' => 'acl'], function () {
            Route::get('roles', 'UserController@roles')->name('roles');
            Route::get('newsletter', 'UserController@newsletter')->name('newsletter');
            Route::get('newsletter/download-csv', 'UserController@newsletterDownloadCsv')->name('newsletter.download.csv');

            Route::group(['prefix' => 'users'], function () {
                Route::get('/', 'UserController@index')->name('users');
                Route::get('{code}', 'UserController@show')->name('users.show');
                Route::get('{code}/edit', 'UserController@edit')->name('users.edit');
                Route::get('{code}/{tab}', 'UserController@show')->name('users.tab');
                Route::post('{email}/reset', 'UserController@resetPassword')->name('users.reset');
                Route::resource('roles', 'RoleController');
                Route::resource('permissions', 'PermissionController');
            });
        });

        /**
         * Lists Routes
         */
        Route::group(['prefix' => 'lists'], function () {
            Route::get('dishes', 'ListController@dishes')->name('dishes');
            Route::get('dishes/{code}', 'ListController@dish')->name('dish');
            Route::get('cuisines', 'ListController@cuisines')->name('cuisines');
            Route::get('cuisines/create', 'ListController@cuisineCreate')->name('cuisine.create');
            Route::get('cuisines/{code}', 'ListController@cuisine')->name('cuisine');
        });


        /**
         * Payments routes 
         */
        Route::group(['prefix' => 'payments'], function () {
            Route::get('/', 'PaymentController@index')->name('payments');
            Route::get('/{code}', 'TicketController@show')->name('payments.show');
        });


        /**
         * Widthdrawals routes 
         */
        Route::group(['prefix' => 'withdrawals'], function () {
            Route::get('/', 'WithdrawalController@index')->name('withdrawals');
            Route::get('/{code}', 'WithdrawalController@show')->name('withdrawals.show');
        });
    });
});
