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

Route::get('/', 'PagesController@index'); //Instead of returning the view, we are going to return a controller.

Route::get('/about', 'PagesController@about');

Route::get('/service', 'PagesController@service');


Route::get('/users/{id}/{name}', function ($id, $name) {
    return 'This is user ' . $name. ' with an id of ' . $id;
});
