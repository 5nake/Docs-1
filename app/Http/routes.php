<?php
/**
 * @Warning: Use `php artisan laroute:generate` after update this file
 */


Route::get('/',             ['uses' => 'HomeController@index',        'as' => 'home']);
Route::post('/view/{name}', ['uses' => 'ViewController@get',          'as' => 'view'])
    ->where('name', '[\.a-z]+');
Route::get('/login',        ['uses' => 'AuthController@verifyCode',   'as' => 'auth.login']);
Route::post('/logout',      ['uses' => 'AuthController@logout',       'as' => 'auth.logout']);


Route::group(['prefix' => 'docs', 'middleware' => 'auth'], function () {

    Route::get('all.json',      ['uses' => 'DocsController@getAllDocuments',  'as' => 'docs.all']);
    Route::post('upload.json',  ['uses' => 'DocsController@upload',           'as' => 'docs.upload']);

});

