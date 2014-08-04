<?php
Route::get('/',         ['as' => 'home',   'uses' => 'HomeController@index']);

Route::get('/auth',     ['as' => 'auth',   'uses' => 'HomeController@auth']);

Route::get('/logout',   ['as' => 'logout', 'uses' => 'HomeController@logout']);





Route::group(['prefix' => 'upload'], function(){
    Route::post('/',  ['as' => 'upload', 'uses' => 'UploadController@upload']);
    Route::get('all', ['as' => 'upload', 'uses' => 'UploadController@all']);
    Route::post('delete/{id}', 'UploadController@delete')
        ->where('id', '[0-9]+');
    Route::post('update/{id}', 'UploadController@update')
        ->where('id', '[0-9]+');
});

Route::get('/d/{token}',        ['as' => 'download', 'uses' => 'DownloadController@download'])
    ->where('token', '.*?');
Route::get('/stream/{token}',   ['as' => 'stream', 'uses' => 'DownloadController@stream'])
    ->where('token', '.*?');
