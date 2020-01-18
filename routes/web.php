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

Route::get('/', function () {
    if (Auth::guest()) {
        return Redirect::to('login');
    }
    if (Auth::check()) {
        return Redirect::to('home');
    }
});

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['guest']], function () {
    Route::get('/user/request', 'Auth\UserController@request');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    if (App::environment('local')) {
        Route::get('catalogue/export', 'Catalogue\EntriesController@exportCatalogue');
        Route::post('catalogue/import', 'Catalogue\EntriesController@importCatalogue');
        Route::get('catalogue/delete', 'Catalogue\EntriesController@deleteCatalogue');
        Route::get('catalogue/upload', 'Catalogue\EntriesController@uploadCatalogue');
    }

    Route::get('entries/search', 'Catalogue\EntriesController@search');
    Route::get('catalogue/search', 'Catalogue\EntriesController@searchCatalogue');
    Route::get('entries/{entry}/copy', 'Catalogue\EntriesController@copy');

    Route::resource(
        'entries',
        'Catalogue\EntriesController',
        ['only' => ['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']]
    );

    Route::get('entries/{entry}/links', 'Catalogue\LinksController@index');
    Route::get('entries/{entry}/links/create', 'Catalogue\LinksController@create');
    Route::get('entries/{entry}/links/search', 'Catalogue\LinksController@searchCatalogue');
    Route::post('entries/{entry}/links', 'Catalogue\LinksController@store');
    Route::delete('entries/{entry}/links/{link}', 'Catalogue\LinksController@destroy');

    Route::get('/admin', 'Auth\UserController@create')->middleware('password.confirm');
    // Route::get('/admin/user', 'Auth\UserController@create');
    // Route::post('/admin/user', 'Auth\UserController@store');

    Route::get('/home', 'HomeController@index')->name('home');
});
