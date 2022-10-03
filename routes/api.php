<?php

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

Route::group(['prefix' => 'mobile', 'namespace' => 'Api\Mobile'], function () {
    Route::get('lists', 'AppController@lists');
    Route::post('signup', 'AuthController@signup');
    Route::post('signin', 'AuthController@signin');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('me', 'AuthController@me');
        Route::post('me', 'UserController@updateMe');
        Route::get('verify-pin/{pin}', 'UserController@verifyPin');
        Route::post('profile', 'UserController@updateProfile');
        Route::post('file-upload', 'DocumentController@uploadDocument');
        Route::post('cards', 'UserController@udpateCard');
        Route::post('ratings', 'UserController@rate');

        Route::group(['prefix' => 'cuisines'], function () {
            Route::get('/', 'CuisineController@index');
            Route::get('{code}', 'CuisineController@show');
            Route::get('{code}/chefs', 'CuisineController@chefs');
        });

        Route::group(['prefix' => 'chefs'], function () {
            Route::get('/', 'UserController@getChefs');
            Route::get('{code}', 'UserController@getChef');
            Route::get('{code}/dishes', 'UserController@getChefDishes');
            Route::get('{code}/bookings', 'BookingController@getChefBookings');
        });

        Route::group(['prefix' => 'dishes'], function () {
            Route::post('/', 'DishController@store');
            Route::patch('{code}', 'DishController@update');
            Route::post('{code}/image', 'DishController@saveImage');
        });

        Route::group(['prefix' => 'comments'], function () {
            Route::post('/', 'CommentController@store');
        });

        Route::group(['prefix' => 'bookings'], function () {
            Route::post('/', 'BookingController@store');
            Route::get('/', 'BookingController@index');
            Route::get('{code}', 'BookingController@getBooking');
            Route::patch('{code}', 'BookingController@updateBooking');
            Route::post('{code}/finish', 'BookingController@finishBooking');
        });

        Route::group(['prefix' => 'documents'], function () {
            Route::get('/', 'DocumentController@getUserDocuments');
            Route::post('user', 'DocumentController@assignUser');
        });

        Route::group(['prefix' => 'earnings'], function () {
            Route::get('/', 'EarningController@getEarnings');
        });

        Route::group(['prefix' => 'tickets'], function () {
            Route::get('/', 'TicketController@index');
            Route::post('/', 'TicketController@store');
            Route::get('/{code}', 'TicketController@show');
            Route::patch('/{code}', 'TicketController@update');
        });

        Route::group(['prefix' => 'withdrawals'], function () {
            Route::get('/', 'WithdrawalController@getWithdrawals');
            Route::post('/', 'WithdrawalController@storeWithdrawal');
        });

        Route::group(['prefix' => 'availability'], function () {
            Route::post('/', 'AvailabilityController@update');
            Route::get('/', 'AvailabilityController@show');
            Route::get('/{code}', 'AvailabilityController@show');
        });
    });
});


/**
 * Admin API routes 
 */
Route::group([
    'prefix' => 'v1', 
    'middleware' => 'auth:api', 
    'namespace' => 'Api\V1'], 
    function () 
{
    Route::post('upload', 'DocumentController@upload');
    
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UserController@index');
        Route::get('/roles', 'UserController@roles');
        Route::get('/admins', 'UserController@getAdmins');
        Route::get('{code}', 'UserController@show');
        Route::patch('{code}', 'UserController@update');
        Route::get('{code}/bookings', 'UserController@getBookings');
        Route::get('{code}/documents', 'UserController@getDocuments');
        Route::patch('{code}/documents/{uuid}', 'UserController@updateDocuments');
    });


    Route::group(['prefix' => 'comments'], function () {
        Route::post('/', 'CommentController@store');
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', 'RoleController@index');
        Route::post('/documents', 'RoleController@addDocument');
    });

    Route::group(['prefix' => 'documents'], function () {
        Route::patch('/{code}', 'DocumentController@update');
        Route::delete('/{code}', 'DocumentController@delete');
    });

    Route::group(['prefix' => 'newsletter'], function () {
        Route::get('/', 'UserController@getNewsletter');
    });

    Route::group(['prefix' => 'tickets'], function () {
        Route::get('/', 'TicketController@index');
        Route::get('/{code}', 'TicketController@show');
        Route::patch('/{code}', 'TicketController@update');
    });

    Route::group(['prefix' => 'bookings'], function () {
        Route::get('/', 'BookingController@index');
        Route::get('/{code}', 'BookingController@show');
        Route::patch('/{code}', 'BookingController@update');
    });

    Route::group(['prefix' => 'cuisines'], function () {
        Route::get('/', 'ListController@cuisines');
        Route::get('/{code}', 'ListController@cuisine');
        Route::patch('/{code}', 'ListController@cuisineUpdate');
        Route::post('/', 'ListController@cuisineCreate');
    });

    Route::group(['prefix' => 'dishes'], function () {
        Route::get('/', 'ListController@dishes');
        Route::get('/{code}', 'ListController@dish');
        Route::patch('/{code}', 'ListController@dishUpdate');
        Route::patch('/{code}/image', 'ListController@dishUpdateImage');
    });

    Route::group(['prefix' => 'payments'], function () {
        Route::get('/', 'PaymentController@index');
        Route::get('/{code}', 'PaymentController@show');
    });

    Route::group(['prefix' => 'withdrawals'], function () {
        Route::get('/', 'WithdrawalController@getWithdrawals');
        Route::get('/{code}', 'WithdrawalController@getWithdrawal');
        Route::patch('/{code}', 'WithdrawalController@updateWithdrawal');
    });
});