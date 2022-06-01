<?php

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

$cp_route_name = config('app.cp_route_name');
Route::get('changeLang/{locale}/{goto?}', "SiteController@changeLang");

Route::group(['namespace' => 'Admin', 'prefix' => $cp_route_name], function () {
    Route::group(['middleware' => 'admin'], function () {
        Route::get('changeLang/{locale}/{goto?}', "SettingController@changeLang")->name('admin.changeLang');

        Route::group(['prefix' => 'setting'], function () {
            Route::get('/', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('edit_setting');
            Route::post('/', ['as' => 'update_setting', 'uses' => 'SettingController@update']);
        });
        Route::group(['prefix' => 'profile'], function () {
            Route::get('edit', ['uses' => 'UserController@profile']);
            Route::get('overview', ['as' => 'profile_overview', 'uses' => 'UserController@profileOverview']);
            Route::post('updateProfile', ['uses' => 'UserController@updateProfile']);
        });
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', ['as' => 'user_view', 'uses' => 'UserController@index']);
            Route::get('list', ['as' => 'user_list', 'uses' => 'UserController@get']);
            Route::get('changeStatus', ['as' => 'change_user_status', 'uses' => 'UserController@changeStatus']);
            Route::post('changePassword', ['as' => 'change_user_password', 'uses' => 'UserController@changePassword']);
            Route::get('changeRole', ['as' => 'change_user_role', 'uses' => 'UserController@changeRole']);
            Route::get('create', ['as' => 'create_user', 'uses' => 'UserController@create']);
            Route::post('create', ['as' => 'store_user', 'uses' => 'UserController@store']);
            Route::get('edit/{id}', ['as' => 'edit_user', 'uses' => 'UserController@edit']);
            Route::post('edit/{id}', ['as' => 'update_user', 'uses' => 'UserController@update']);
            Route::get('actionRole/{id}', ['as' => 'action_role', 'uses' => 'UserController@actionRole']);
            Route::post('validateInput/{id?}', ['uses' => 'UserController@validateInput']);
            Route::get('delete/{id}', ['as' => 'user_delete', 'uses' => 'UserController@delete']);
            // end user routes
        });
        Route::group(['prefix' => 'role'], function () {
            Route::get('/', ['as' => 'role_view', 'uses' => 'RoleController@index']);
            Route::get('list', ['as' => 'role_list', 'uses' => 'RoleController@get']);
            Route::get('changeStatus/{id}', ['as' => 'change_role_status', 'uses' => 'RoleController@changeStatus']);
            Route::get('create', ['as' => 'create_role', 'uses' => 'RoleController@create']);
            Route::post('create', ['as' => 'store_role', 'uses' => 'RoleController@store']);
            Route::get('edit/{id}', ['as' => 'edit_role', 'uses' => 'RoleController@edit']);
            Route::post('edit/{id}', ['as' => 'update_role', 'uses' => 'RoleController@update']);
            Route::get('usersCount/{id}', ['as' => 'role_user_count', 'uses' => 'RoleController@usersCount']);
            Route::get('delete/{id}', ['as' => 'usrole_delete', 'uses' => 'RoleController@delete']);
        });

        Route::group(['prefix' => ''], function () {
            //Google Analytics
            Route::post('saveChartImage', ['as' => 'saveChartImage', 'uses' => 'ReportsController@saveChartImage']);
            Route::get('visitorsView', ['as' => 'visitorsView', 'uses' => 'ReportsController@visitorsView']);
            Route::get('keywordsView', ['as' => 'keywordsView', 'uses' => 'ReportsController@keywordsView']);
            Route::get('referrersView', ['as' => 'referrersView', 'uses' => 'ReportsController@referrersView']);
            Route::get('browsersView', ['as' => 'browsersView', 'uses' => 'ReportsController@browsersView']);
            Route::get('mostVisitedView', ['as' => 'mostVisitedView', 'uses' => 'ReportsController@mostVisitedView']);
            Route::get('mobileTrafficView', ['as' => 'mobileTrafficView', 'uses' => 'ReportsController@mobileTrafficView']);
            Route::get('newVsReturningView', ['as' => 'newVsReturningView', 'uses' => 'ReportsController@newVsReturningView']);
            Route::get('countryView', ['as' => 'countryView', 'uses' => 'ReportsController@countryView']);
            Route::get('siteTimeView', ['as' => 'siteTimeView', 'uses' => 'ReportsController@siteTimeView']);

            Route::get('visitors', ['as' => 'visitors', 'uses' => 'ReportsController@visitors']);
            Route::get('keywords', ['as' => 'keywords', 'uses' => 'ReportsController@keywords']);
            Route::get('referrers', ['as' => 'referrers', 'uses' => 'ReportsController@referrers']);
            Route::get('browsers', ['as' => 'browsers', 'uses' => 'ReportsController@browsers']);
            Route::get('mostVisited', ['as' => 'mostVisited', 'uses' => 'ReportsController@mostVisited']);
            Route::get('activeUsers', ['as' => 'activeUsers', 'uses' => 'ReportsController@activeUsers']);
            Route::get('mobileTraffic', ['as' => 'mobileTraffic', 'uses' => 'ReportsController@mobileTraffic']);
            Route::get('newVsReturning', ['as' => 'newVsReturning', 'uses' => 'ReportsController@newVsReturning']);
            Route::get('countryVisit', ['as' => 'country', 'uses' => 'ReportsController@country']);
            Route::get('siteTime', ['as' => 'siteTime', 'uses' => 'ReportsController@siteTime']);
        });

        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', ['as' => 'category_view', 'uses' => 'CategoriesController@index']);
            Route::get('list', ['as' => 'category_list', 'uses' => 'CategoriesController@get']);
            Route::get('create', ['as' => 'create_category', 'uses' => 'CategoriesController@create']);
            Route::post('create', ['as' => 'store_category', 'uses' => 'CategoriesController@store']);
            Route::get('edit/{id}', ['as' => 'edit_category', 'uses' => 'CategoriesController@edit']);
            Route::post('edit/{id}', ['as' => 'update_category', 'uses' => 'CategoriesController@update'])->where(['id' => '[0-9]+']);
            Route::post('delete/{id}', ['as' => 'delete_category', 'uses' => 'CategoriesController@delete'])->where(['id' => '[0-9]+']);
        });

        Route::group(['prefix' => 'posts'], function () {
            Route::get('/', ['as' => 'posts_view', 'uses' => 'PostsController@index']);
            Route::get('list', ['as' => 'posts_list', 'uses' => 'PostsController@get']);
            Route::get('create', ['as' => 'create_post', 'uses' => 'PostsController@create']);
            Route::post('create', ['as' => 'store_post', 'uses' => 'PostsController@store']);
            Route::get('edit/{id}', ['as' => 'edit_post', 'uses' => 'PostsController@edit']);
            Route::post('edit/{id}', ['as' => 'update_post', 'uses' => 'PostsController@update'])->where(['id' => '[0-9]+']);
            Route::post('delete/{id}', ['as' => 'delete_post', 'uses' => 'PostsController@delete'])->where(['id' => '[0-9]+']);
        });
        Route::group(['prefix' => 'events'], function () {
            Route::get('/', ['as' => 'events_view', 'uses' => 'EventsController@index']);
            Route::get('list', ['as' => 'events_list', 'uses' => 'EventsController@get']);
            Route::get('create', ['as' => 'create_event', 'uses' => 'EventsController@create']);
            Route::post('create', ['as' => 'store_event', 'uses' => 'EventsController@store']);
            Route::get('edit/{id}', ['as' => 'edit_event', 'uses' => 'EventsController@edit']);
            Route::post('edit/{id}', ['as' => 'update_event', 'uses' => 'EventsController@update'])->where(['id' => '[0-9]+']);
            Route::post('delete/{id}', ['as' => 'delete_event', 'uses' => 'EventsController@delete'])->where(['id' => '[0-9]+']);
        });
        Route::group(['prefix' => 'banners'], function () {
            Route::get('/', ['as' => 'banners_view', 'uses' => 'BannersController@index']);
            Route::get('list', ['as' => 'banners_list', 'uses' => 'BannersController@get']);
            Route::get('create', ['as' => 'create_banner', 'uses' => 'BannersController@create']);
            Route::post('create', ['as' => 'store_banner', 'uses' => 'BannersController@store']);
            Route::get('edit/{id}', ['as' => 'edit_banner', 'uses' => 'BannersController@edit']);
            Route::post('edit/{id}', ['as' => 'update_banner', 'uses' => 'BannersController@update'])->where(['id' => '[0-9]+']);
            Route::post('delete/{id}', ['as' => 'delete_banner', 'uses' => 'BannersController@delete'])->where(['id' => '[0-9]+']);
        });


        Route::group(['prefix' => 'pages'], function () {
            Route::get('/', ['as' => 'show_pages', 'uses' => 'PagesController@editPages']);
            Route::post('/', ['as' => 'update_pages', 'uses' => 'PagesController@updatePages']);
        });
        Route::group(['prefix' => 'inquiries'], function () {
            Route::get('/', ['as' => 'inquiry_view', 'uses' => 'InquiriesController@index']);
            Route::get('list', ['as' => 'inquiry_list', 'uses' => 'InquiriesController@get']);
            Route::get('show/{id}', ['as' => 'inquiry_show', 'uses' => 'InquiriesController@show']);
        });

        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'getIndex']);
        Route::get('logout', 'LoginController@logout');
        Route::get('lock', 'LoginController@lock');
        Route::post('upload/{name?}', 'SuperAdminController@uploadAjax');
        Route::post('uploadProfile', 'SuperAdminController@uploadProfile');
        Route::post('updatePasswordProfile', 'UserController@updatePasswordProfile');
        Route::get('getIPInfo/{ip}', 'SuperAdminController@getIPInfo');

    });

    Route::group(['middleware' => 'admin.guest'], function () {
        // for login
        Route::get('login', 'LoginController@index');
        Route::post('login', 'LoginController@check');
        Route::get('relogin', 'LoginController@relogin');
    });
});


Route::group([
    'middleware' => ['site', 'localeSessionRedirect', 'localizationRedirect'],
    'prefix' => LaravelLocalization::setLocale()
], function () {
    Route::get('/', 'HomeController@index')->name('site.home');

    Route::get('/posts/{id}/{category?}/{slug?}', 'PostsController@show')->name('post.show');
    Route::get('/category/{category}', 'PostsController@getPostsByCategory')->name('site.getPostsByCategory');
    Route::get('/search', 'HomeController@search')->name('site.search');

    Route::get('/events/{type?}', 'EventsController@index')->name('events.all');
    Route::get('/events/{id}/{type?}/{slug?}', 'EventsController@show')->name('event.show');


    Route::get('/terms', 'PolicyController@terms')->name('site.terms');
    Route::get('/accessibility', 'PolicyController@accessibility')->name('site.accessibility');
    Route::get('/about-us', 'PolicyController@about')->name('site.about');
    Route::get('/safety', 'PolicyController@safety')->name('site.safety');
    Route::get('/contact-us', 'ContactUsController@index')->name('site.contact.index');
    Route::post('/contact-us', 'ContactUsController@submit')->name('site.contact.submit');

    Route::get('/donate', 'DonateController@index')->name('site.donate.index');
    Route::get('/newsMapCount', 'HomeController@newsMapCount');
    Route::get('/latestNews/{countryId?}', 'HomeController@getLatestNews');

});
Route::any('{catchall}', 'HomeController@notfound')->where('catchall', '.*');
