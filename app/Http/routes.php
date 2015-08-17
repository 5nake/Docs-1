<?php
/**
 * @Warning: Use `php artisan laroute:generate` after update this file
 */

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ViewController;


Route::get('/', ['uses' => HomeController::method('index'), 'as' => 'home']);

Route::post('/view/{name}', ['uses' => ViewController::method('get'), 'as' => 'view'])
    ->where('name', '[\.a-z]+');


Route::get('/login', ['uses' => AuthController::method('verifyCode'), 'as' => 'auth.login']);
Route::post('/logout', ['uses' => AuthController::method('logout'), 'as' => 'auth.logout']);


Route::group(['prefix' => 'docs', 'middleware' => 'auth'], function () {

    Route::get('all.json',      ['uses' => DocsController::method('getAllDocuments'), 'as' => 'docs.all']);

    Route::post('upload.json',  ['uses' => DocsController::method('upload'), 'as' => 'docs.upload']);

});
