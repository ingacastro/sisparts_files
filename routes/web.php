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

Route::get('/', function () {
    return redirect('login');
});

Auth::routes(['register' => false]);

Route::get('home', 'HomeController@index')->name('home');

//New logout route, since link is a get request and default logout route is post
Route::get('logout', 'Auth\LoginController@logout');

//Util routes
Route::get('country-states', 'UtilController@getCountryStates');

//Supplier routes
Route::get('brands-id-name', 'SupplierController@getBrandsKeyVal');
Route::post('create-brand', 'SupplierController@createBrand');
Route::post('sync-brands', 'SupplierController@syncBrands')->name('supplier.sync-brands');
Route::resource('supplier', 'SupplierController');

