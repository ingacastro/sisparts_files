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
	Route::get('supplier/get-brands/{id}', 'SupplierController@getModelBrands');
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

//Inbox
Route::get('inbox/get-list', 'InboxController@getList')->name('inbox.get-list');
Route::post('inbox/change-dealership', 'InboxController@changeDealerShip')->name('inbox.change-dealership');
Route::post('inbox/{document}/archive', 'InboxController@archive');
Route::get('inbox/document-supplies', 'InboxController@getDocumentSupplySets');
Route::get('inbox/get-set-tabs/{set_id}', 'InboxController@getSetTabs');
Route::post('inbox/update-set-budget/{set_id}', 'InboxController@updateBudget')->name('inbox.update-set-budget');
Route::post('inbox/check-checklist-item', 'InboxController@checkChecklistItem');
Route::post('inbox/update-set-conditions/{set_id}', 'InboxController@updateConditions')->name('inbox.update-set-conditions');
Route::get('inbox/get-condition-value/{condition_id}/{field}', 'InboxController@getConditionValue');
Route::get('inbox/set-files/{set_id}', 'InboxController@getSetFiles');
Route::post('inbox/sets-file-attachment', 'InboxController@setsFileAttachment')->name('inbox.sets-file-attachment');
Route::get('inbox/document-sets-files/{document_id}', 'InboxController@getDocumentSetsFiles');
Route::delete('inbox/set-file-detach/{set_id}/{file_id}', 'InboxController@setFileDetach');
Route::get('inbox/get-manufacturer-suppliers/{manufacturer_id}', 'InboxController@getManufacturerSuppliers');
Route::post('inbox/send-suppliers-quotation', 'InboxController@sendSuppliersQuotation')->name('inbox.send-suppliers-quotation');

/*Route::post('inbox/set-ctz-status', 'InboxController@setCTZStatus');*/
Route::resource('inbox', 'InboxController');

