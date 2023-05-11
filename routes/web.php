<?php

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

$cp_route_name = config('app.cp_route_name');
Route::get('changeLang/{locale}/{goto?}', [\App\Http\Controllers\SiteController::class, 'changeLang'])->name('app.language.switch');

Route::group(['namespace' => 'Admin', 'prefix' => $cp_route_name], function () {
    Route::group(['middleware' => 'admin'], function () {
        Route::get('changeLang/{locale}/{goto?}', [\App\Http\Controllers\Admin\SettingController::class, 'changeLang'])->name('admin.changeLang');

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
        Route::group(['prefix' => 'pages'], function () {
            Route::get('/', ['as' => 'show_pages', 'uses' => 'PagesController@editPages']);
            Route::post('/', ['as' => 'update_pages', 'uses' => 'PagesController@updatePages']);
        });
        Route::group(['prefix' => 'inquiries'], function () {
            Route::get('/', ['as' => 'inquiry_view', 'uses' => 'InquiriesController@index']);
            Route::get('list', ['as' => 'inquiry_list', 'uses' => 'InquiriesController@get']);
            Route::get('show/{id}', ['as' => 'inquiry_show', 'uses' => 'InquiriesController@show']);
        });
        Route::group(['prefix' => 'donations'], function () {
            Route::get('/', ['as' => 'donation_view', 'uses' => 'DonationsController@index']);
            Route::get('list', ['as' => 'donation_list', 'uses' => 'DonationsController@get']);
            Route::get('show/{id}', ['as' => 'donation_show', 'uses' => 'DonationsController@show']);
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
    Route::post('/donate', 'DonateController@store')->name('site.donate.store');
    Route::get('/newsMapCount', 'HomeController@newsMapCount');
    Route::get('/latestNews/{countryId?}', 'HomeController@getLatestNews');

});

Route::any('{catchall}', 'HomeController@notfound')->where('catchall', '.*');
