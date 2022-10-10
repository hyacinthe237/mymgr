<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::group(['namespace' => 'Views\Frontend'], function () {
//     Route::get('/', 'HomeController@index');
//     Route::get('about', 'HomeController@about');
//     Route::get('terms', 'HomeController@terms');
//     Route::get('contact', 'HomeController@contact');
//     Route::get('privacy', 'HomeController@privacy');
//     Route::get('become-chef', 'HomeController@chef');
//     Route::post('contact', 'HomeController@postContact');
//     Route::post('newsletter', 'HomeController@postEmail');
// });

// Route::get('/', 'Views\Frontend\HomeController@index')->name('home');
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('login', 'Views\Frontend\AuthController@login')->name('login');
    Route::get('signup', 'Views\Frontend\AuthController@signup')->name('signup');
    Route::post('login', 'Views\Frontend\AuthController@signin');
    Route::group(['prefix' => 'auth'], function () {
        Route::get('signup', 'Views\Frontend\AuthController@signup')->name('auth.signup');
        Route::post('signup', 'Views\Frontend\AuthController@register');
    });
    Route::get('join/{code}', 'Views\Frontend\TeamController@invitation');
});


/**
 * Routes protected by Auth
 * @var [type]
 */
Route::group(['middleware' => ['auth']], function () {
    Route::get('/logout', 'Views\Frontend\AuthController@signout')->name('logout');
    Route::get('organization', 'Views\Frontend\OrganizationController@select')->name('organization.select');
    Route::get('organizations/{code}/set', 'Views\Frontend\OrganizationController@set')->name('organizations.set');
    Route::get('organizations/create', 'Views\Frontend\OrganizationController@create')->name('organizations.create');
    Route::get('organizations/{code}/join', 'Views\Frontend\OrganizationController@join')->name('organizations.join');
    Route::get('organization/join', 'Views\Frontend\AuthController@organization')->name('organization.join.page');

    Route::group(['prefix' => 'uploads'], function () {
        Route::post('project/{code}', 'Views\Frontend\UploadController@project')->name('uploads.project');
        Route::post('members/{code}', 'Views\Frontend\UploadController@member');
        Route::post('ticket/{number}', 'Views\Frontend\UploadController@ticket');
    });

    Route::group(['prefix' => 'downloads'], function () {
        Route::post('file/{code}', 'Views\Frontend\FileController@download')->name('file.download');
    });

    // Only users with an organization can access these routes
    Route::group(['middleware' => 'organization'], function () {
        Route::get('profile', 'Views\Frontend\AuthController@profile')->name('auth.profile');
        Route::get('mytickets', 'Views\Frontend\UserController@mytickets')->name('mytickets');
        Route::get('dashboard', 'Views\Frontend\DashboardController@index')->name('dashboard');

        Route::group(['prefix' => 'tickets'], function () {
            Route::get('/', 'Views\Frontend\TicketController@index')->name('tickets.index');
            Route::get('/create', 'Views\Frontend\TicketController@create');
            Route::get('/{ticketId}', 'Views\Frontend\TicketController@show')->name('tickets.show');
            Route::get('/{ticketId}/edit', 'Views\Frontend\TicketController@edit')->name('tickets.edit');
            Route::get('/{ticketId}/close', 'Views\Frontend\TicketController@close')->name('tickets.close');
        });

        Route::group(['prefix' => 'organizations'], function () {
            Route::get('/', 'Views\Frontend\OrganizationController@index')->name('organizations.index');
            Route::get('/{organizationId}', 'Views\Frontend\OrganizationController@show');
            Route::get('/{organizationId}/edit', 'Views\Frontend\OrganizationController@edit');
        });

        Route::group(['prefix' => 'projects'], function () {
            Route::get('/', 'Views\Frontend\ProjectController@index')->name('projects.index');
            Route::get('/create', 'Views\Frontend\ProjectController@create');
            Route::get('/details', 'Views\Frontend\ProjectController@details');
            Route::post('/', 'Views\Frontend\ProjectController@store');

            Route::group(['prefix' => '{code}'], function () {
                Route::get('/', 'Views\Frontend\ProjectController@show')->name('project.show');
                Route::get('edit', 'Views\Frontend\ProjectController@edit')->name('project.edit');
                Route::get('tickets', 'Views\Frontend\ProjectController@tickets')->name('project.tickets');
                Route::get('stats', 'Views\Frontend\ProjectController@stats')->name('project.stats');
                Route::get('tickets/create', 'Views\Frontend\TicketController@create')->name('project.tickets.create');
            });
        });

        Route::group(['prefix' => 'team'], function () {
            Route::get('/', 'Views\Frontend\TeamController@index')->name('teams.index');
            Route::get('/create', 'Views\Frontend\TeamController@create');
        });

        Route::group(['prefix' => 'search'], function () {
            Route::get('/', 'Views\Frontend\OrganizationController@search');
        });

        Route::group(['prefix' => 'notifications'], function () {
            Route::get('/', 'Views\Frontend\NotificationController@notifications');
            Route::get('/unread', 'Views\Frontend\NotificationController@unread');
        });

        // Members is a synonym for team  and is used to avoid confusion around the work "team"
        Route::group(['prefix' => 'members'], function () {
            Route::get('/', 'Views\Frontend\TeamController@index')->name('members.index');
            Route::get('/{code}', 'Views\Frontend\UserController@show')->name('members.show');
        });
    });
});


Route::get('number/test', function () {

  $model= new App\Models\Ticket;

  echo generate_number($model);

  die();


});
