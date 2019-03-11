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

Route::group(['middleware' => ['role:Administrador|Cotizador']], function(){
	Route::get('dashboard', 'DashboardController@index')->name('dashboard');
});

//New logout, since link is a get request and default logout route is post
Route::get('logout', 'Auth\LoginController@logout');

//Util
Route::get('country-states', 'UtilController@getCountryStates');

//Supplier
Route::get('supplier/brands-id-name', 'SupplierController@getBrandsKeyVal');
Route::group(['middleware' => ['role:Administrador|Cotizador']], function(){
	Route::get('supplier/get-list', 'SupplierController@getList');
	Route::post('supplier/create-brand', 'SupplierController@createBrand');
	Route::post('supplier/sync-brands', 'SupplierController@syncBrands')->name('supplier.sync-brands');
	Route::resource('supplier', 'SupplierController');
});

//Admin
Route::group(['middleware' => ['role:Administrador']], function(){
	
	//User
	Route::get('user/get-list', 'UserController@getList');
	Route::resource('user', 'UserController');

	//ColorSettings
	Route::get('color-settings/edit', 'ColorSettingController@edit')->name('settings.edit');
	Route::post('color-settings', 'ColorSettingController@store')->name('settings.store');

	//Messages
	Route::get('message/get-list', 'MessageController@getList');
	Route::resource('message', 'MessageController');
});

