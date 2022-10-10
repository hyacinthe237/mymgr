<?php

use Illuminate\Support\Facades\Route;
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

Route::group(['middleware' => ['auth:api']], function () {

    Route::group(['middleware' => 'organization'], function () {
        Route::get('user-tickets', 'Api\V1\TicketController@userTickets');

        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'Api\V1\UserController@index');
            Route::post('/', 'Api\V1\UserController@store');
            Route::get('/{userId}', 'Api\V1\UserController@show');
            Route::put('/{userId}', 'Api\V1\UserController@update');
            Route::delete('/{userId}', 'Api\V1\UserController@destroy');
            Route::get('/{userId}/blocked', 'Api\V1\UserController@blocked');
        });

        Route::group(['prefix' => 'tickets'], function () {
            Route::get('/', 'Api\V1\TicketController@index');
            Route::post('/', 'Api\V1\TicketController@store');
            Route::get('/{ticketId}', 'Api\V1\TicketController@show');
            Route::put('/{ticketId}', 'Api\V1\TicketController@update');
            Route::delete('/{ticketId}', 'Api\V1\TicketController@destroy');
            Route::post('/{ticketId}/comments', 'Api\V1\TicketController@addComment');
            Route::get('/{ticketId}/comments', 'Api\V1\TicketController@listComments');

            Route::group(['prefix' => '{number}'], function () {
                Route::get('remove/attachments/{file_code}', 'Api\V1\TicketController@removeFile');
                Route::get('activity', 'Api\V1\TicketController@activity');
            });

        });

        Route::group(['prefix' => 'ticket-categories'], function () {
            Route::get('/', 'Api\V1\TicketCategoryController@index');
            Route::post('/', 'Api\V1\TicketCategoryController@store');
            Route::get('/{TicketCategoryId}', 'Api\V1\TicketCategoryController@show');
            Route::put('/{TicketCategoryId}', 'Api\V1\TicketCategoryController@update');
            Route::delete('/{TicketCategoryId}', 'Api\V1\TicketCategoryController@destroy');
        });

        Route::group(['prefix' => 'projects'], function () {
            Route::get('/', 'Api\V1\ProjectController@index');
            Route::post('/', 'Api\V1\ProjectController@store');
            Route::get('/{projectId}', 'Api\V1\ProjectController@show');
            Route::put('/{projectId}', 'Api\V1\ProjectController@update');
            Route::delete('/{projectId}', 'Api\V1\ProjectController@destroy');
            Route::post('/{projectId}/comments', 'Api\V1\ProjectController@addComment');
            Route::get('/{projectId}/comments', 'Api\V1\ProjectController@listComments');

            Route::group(['prefix' => '{code}'], function () {
                Route::get('tickets', 'Api\V1\ProjectController@tickets');
                Route::get('remove/attachments/{file_code}', 'Api\V1\ProjectController@removeFile');
            });
        });

        Route::group(['prefix' => 'project-categories'], function () {
            Route::get('/', 'Api\V1\ProjectCategoryController@index');
            Route::post('/', 'Api\V1\ProjectCategoryController@store');
            Route::get('/{projectCategoryId}', 'Api\V1\ProjectCategoryController@show');
            Route::put('/{projectCategoryId}', 'Api\V1\ProjectCategoryController@update');
            Route::delete('/{projectCategoryId}', 'Api\V1\ProjectCategoryController@destroy');
        });

        Route::group(['prefix' => 'invitations'], function () {
            Route::get('/', 'Api\V1\InvitationController@index');
            Route::post('/', 'Api\V1\InvitationController@store');
            Route::get('/{invitationId}', 'Api\V1\InvitationController@show');
            Route::put('/{invitationId}', 'Api\V1\InvitationController@update');
            Route::delete('/{invitationId}', 'Api\V1\InvitationController@destroy');
        });


        Route::group(['prefix' => 'members'], function () {
            Route::get('/', 'Api\V1\MemberController@index');
            Route::delete('{code}', 'Api\V1\MemberController@destroy');
        });
    });



    Route::group(['prefix' => 'organizations'], function () {
        Route::get('/', 'Api\V1\OrganizationController@index');
        Route::post('/', 'Api\V1\OrganizationController@store');
        Route::get('/{organizationId}', 'Api\V1\OrganizationController@show');
        Route::put('/{organizationId}', 'Api\V1\OrganizationController@update');
        Route::delete('/{organizationId}', 'Api\V1\OrganizationController@destroy');
    });


    Route::post('addprivate', 'Api\V1\ProjectController@addPrivate');
    Route::get('getPrivateUsers/{code}', 'Api\V1\ProjectController@getPrivateUsers');
    Route::post('removePrivateUsers', 'Api\V1\ProjectController@removePrivateUsers');
    Route::get('getNotPrivateUsers/{code}', 'Api\V1\ProjectController@getNotPrivateUsers');
});
