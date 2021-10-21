<?php

use Illuminate\Support\Facades\Route;

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

//Auth::routes();

Route::get('/',                     'HomeController@index');
Route::post('/',                    'HomeController@index');
Route::get('logout',                'HomeController@logout');

Route::get('/menu',                 'MenuController@edit');
Route::get('/menu/ajax/{week}',     'MenuController@ajax');
Route::put('/menu',                 'MenuController@update');

Route::get('/course',               'CourseController@index');
Route::get('/course/create',        'CourseController@create');
Route::post('/course',              'CourseController@store');
Route::get('/course/{course}/edit', 'CourseController@edit');
Route::put('/course/{course}',      'CourseController@update');
Route::delete('/course/{course}',   'CourseController@destroy');
