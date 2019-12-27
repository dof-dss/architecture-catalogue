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
    return view('home');
});

if (App::environment('local')) {
    Route::get('catalogue/upload', 'Catalogue\EntriesController@uploadCatalogue');
    Route::post('catalogue/import', 'Catalogue\EntriesController@importCatalogue');
    Route::get('catalogue/delete', 'Catalogue\EntriesController@deleteCatalogue');
}

Route::resource(
    'entries',
    'Catalogue\EntriesController',
    ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]
);
