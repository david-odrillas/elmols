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
Route::resource('clients.sales', 'SaleUserController')->only(['index','create','store']);
Route::resource('sales.details', 'DetailController')->only('index');  ///revisar metodos
Route::resource('clients.wallets', 'WalletController')->only('index');

Route::get('clients/{client}/payments', 'WalletController@month')->name('clients.payments');
Route::post('clients/{client}/payments', 'WalletController@search')->name('payments.search');
Route::post('clients/{client}/pay','WalletController@payment')->name('payments.payments');
Route::get('clients/{client}/pay','WalletController@list')->name('payments.list');
Route::get('report/select', 'ReportController@select')->name('reports.select');
Route::post('reports/today', 'ReportController@today')->name('reports.today');
Route::post('reports/day', 'ReportController@day')->name('reports.day');
Route::post('reports/month', 'ReportController@month')->name('reports.month');
Route::post('reports/range', 'ReportController@range')->name('reports.range');
