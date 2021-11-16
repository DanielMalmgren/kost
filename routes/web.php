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

Route::get('/',                         'HomeController@index');
Route::post('/',                        'HomeController@index');
Route::get('logout',                    'HomeController@logout');

Route::get('/menu',                     'MenuController@edit');
Route::get('/menu/ajax/{week}',         'MenuController@ajax');
Route::put('/menu',                     'MenuController@update');
Route::get('/menu/pdf/{week}',          'MenuController@pdf');

Route::get('/course',                   'CourseController@index');
Route::get('/course/create',            'CourseController@create');
Route::post('/course',                  'CourseController@store');
Route::get('/course/{course}/edit',     'CourseController@edit');
Route::put('/course/{course}',          'CourseController@update');
Route::delete('/course/{course}',       'CourseController@destroy');

Route::get('/homecareorder',            'HomeCareOrderController@index');
Route::get('/homecareorder/listajax',   'HomeCareOrderController@listajax');
Route::get('/homecareorder/create',     'HomeCareOrderController@create');
Route::get('/homecareorder/ajax',       'HomeCareOrderController@ajax');
Route::post('/homecareorder',           'HomeCareOrderController@store');

Route::get('/customer',                 'CustomerController@index');
Route::get('/customer/create',          'CustomerController@create');
Route::post('/customer',                'CustomerController@store');
Route::get('/customer/{customer}/edit', 'CustomerController@edit');
Route::put('/customer/{customer}',      'CustomerController@update');
Route::delete('/customer/{customer}',   'CustomerController@destroy');
