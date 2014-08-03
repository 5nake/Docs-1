<?php
Route::get('/',         ['as' => 'home',   'uses' => 'HomeController@index']);

Route::get('/auth',     ['as' => 'auth',   'uses' => 'HomeController@auth']);

Route::get('/logout',   ['as' => 'logout', 'uses' => 'HomeController@logout']);





Route::group(['prefix' => 'upload'], function(){
    Route::post('/',  ['as' => 'upload', 'uses' => 'UploaderController@upload']);
    Route::get('all', ['as' => 'upload', 'uses' => 'UploaderController@all']);
    Route::post('delete/{id}', 'UploaderController@delete')
        ->where('id', '[0-9]+');
    Route::post('update/{id}', 'UploaderController@update')
        ->where('id', '[0-9]+');
});
Route::get('/d/{token}', 'UploaderController@download')
    ->where('token', '.*?');