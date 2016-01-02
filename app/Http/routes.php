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
Route::get('/app', ['as' => 'app', 'uses' => 'MainController@app']);

/**
 * album routes
 */
Route::get('/albums', ['as' => 'albums', 'uses' => 'AlbumController@index']);

Route::get('/albums/list', ['as' => 'list', 'uses' => 'AlbumController@albumList']);

Route::post('/albums/create', ['as' => 'create', 'uses' => 'AlbumController@add']);

Route::put('/albums/edit/{id}', ['as' => 'edit', 'uses' => 'AlbumController@update']);

Route::delete('/albums/delete/{id}', ['as' => 'delete', 'uses' => 'AlbumController@delete']);

Route::get('/albums/detail/{id}', ['as' => 'detail', 'uses' => 'AlbumController@detail']);

Route::get('/albums/artist/delete/{id}/{artist}', ['as' => 'album_artist_delelete', 'uses' => 'ArtistController@roleDelete']);

/**
 * artist routes
 */
Route::get('/artists', ['as' => 'artists', 'uses' => 'ArtistController@index']);

Route::get('/artists/list', ['as' => 'artists_list', 'uses' => 'ArtistController@artistList']);

Route::post('/artists/create', ['as' => 'artists_create', 'uses' => 'ArtistController@add']);

Route::put('/artists/edit/{id}', ['as' => 'artists_edit', 'uses' => 'ArtistController@update']);

Route::delete('/artists/delete/{id}', ['as' => 'artists_delete', 'uses' => 'ArtistController@delete']);

Route::get('/artists/detail/{id}', ['as' => 'artists_detail', 'uses' => 'ArtistController@detail']);

Route::get('/artists/role/delete/{id}/{role}', ['as' => 'artists_role_delelete', 'uses' => 'ArtistController@roleDelete']);

/**
 * roles routes
 */

Route::get('/roles/list', ['as' => 'roles_list', 'uses' => 'RolesController@rolesList']);

Route::post('/roles/create', ['as' => 'roles_create', 'uses' => 'RolesController@add']);

Route::put('/roles/edit/{id}', ['as' => 'roles_edit', 'uses' => 'RolesController@update']);

Route::delete('/roles/delete/{id}', ['as' => 'roles_delete', 'uses' => 'RolesController@delete']);

Route::get('/roles/detail/{id}', ['as' => 'roles_detail', 'uses' => 'RolesController@detail']);


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
