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

//Should be middleware, but having issues with preflight
header('Access-Control-Allow-Origin: *');
header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );

Route::get('/rest/usernamesSearched', 'ApiController@usernamesSearched');
Route::post('/rest/evaluateUsernames', 'ApiController@evaluateUsernames');
Route::get('/rest/batch/{id}', 'ApiController@getBatch');
Route::post('/rest/batch/{id}/setEmail', 'ApiController@setBatchEmail');

Route::middleware('cors')->get('/', function () {
    View::addExtension('html', 'php');
    return View::make('index');
});


Route::middleware('cors')->get('/{slug}', function () {
    View::addExtension('html', 'php');
    return View::make('index');
});
