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

Route::get('/menu_ao',                  'MenuAOController@edit');
Route::get('/menu_ao/ajax/{week}',      'MenuAOController@ajax');
Route::put('/menu_ao',                  'MenuAOController@update');

Route::get('/course_ao',                'CourseAOController@index');
Route::get('/course_ao/create',         'CourseAOController@create');
Route::post('/course_ao',               'CourseAOController@store');
Route::get('/course_ao/{course}/edit',  'CourseAOController@edit');
Route::put('/course_ao/{course}',       'CourseAOController@update');
Route::delete('/course_ao/{course}',    'CourseAOController@destroy');

Route::get('/department_ao',                    'DepartmentAOController@index');
Route::get('/department_ao/create',             'DepartmentAOController@create');
Route::post('/department_ao',                   'DepartmentAOController@store');
Route::get('/department_ao/{department}/edit',  'DepartmentAOController@edit');
Route::put('/department_ao/{department}',       'DepartmentAOController@update');
Route::delete('/department_ao/{department}',    'DepartmentAOController@destroy');
