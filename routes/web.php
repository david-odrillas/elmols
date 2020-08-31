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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
Route::put('products/{product}/restore', 'ProductController@restore')->name('products.restore');
Route::get('products/deletes', 'ProductController@deletes')->name('products.deletes');
Route::resource('products', 'ProductController')->except('show');
Route::resource('products.units', 'UnitProductController')->except('show');

Route::resource('clients', 'UserController')->except(['show','destroy']);
Route::resource('clients.refers', 'ReferController')->only(['index', 'create', 'store']);
Route::get('/search', 'SaleController@search');
Route::resource('sales', 'SaleController')->only(['index', 'store']);
Route::resource('clients.sales', 'SaleUserController')->only(['create','store']);
Route::resource('sales.details', 'DetailController')->only('index');  ///revisar metodos
