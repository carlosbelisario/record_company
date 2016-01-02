<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['as' => 'index', 'uses' => 'MainController@index']);

Route::get('/artist', ['as' => 'artist', 'uses' => 'ArtistController@artistList']);

Route::get('/albums', ['as' => 'albums', 'uses' => 'AlbumController@albumList']);

Route::post('/albums/create', ['as' => 'create', 'uses' => 'AlbumController@add']);

Route::put('/albums/edit/{id}', ['as' => 'edit', 'uses' => 'AlbumController@update']);

Route::delete('/albums/delete/{id}', ['as' => 'delete', 'uses' => 'AlbumController@delete']);

Route::get('/albums/detail/{id}', ['as' => 'detail', 'uses' => 'AlbumController@detail']);



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
