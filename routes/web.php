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

//New logout route, since link is a get request and default logout route is post
Route::get('logout', 'Auth\LoginController@logout');

//Util routes
Route::get('country-states', 'UtilController@getCountryStates');

//Supplier routes
Route::prefix('supplier')->group(function(){
	Route::get('brands-id-name', 'SupplierController@getBrandsKeyVal');
	Route::post('create-brand', 'SupplierController@createBrand');
	Route::post('sync-brands', 'SupplierController@syncBrands')->name('supplier.sync-brands');
	Route::get('get-list', 'SupplierController@getList');
});
Route::resource('supplier', 'SupplierController');

//User routes
Route::prefix('user')->group(function(){
	Route::get('get-list', 'UserController@getList');
});
Route::resource('user', 'UserController');

//ColorSettings
Route::prefix('color-settings')->group(function(){	
	Route::get('edit', 'ColorSettingController@edit')->name('settings.edit');
	Route::post('', 'ColorSettingController@store')->name('settings.store');
});


