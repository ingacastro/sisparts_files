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

//Password reset routes disabled
Route::post('password/email', function(){ abort(404); })->name('password.email');
Route::post('password/reset', function(){ abort(404); })->name('password.update');
Route::get('password/reset', function(){ abort(404); })->name('password.request');
Route::get('password/reset/{token}', function(){ abort(404); })->name('password.reset');

Route::group(['middleware' => ['role:Administrador|Cotizador']], function() {
	Route::get('dashboard/get-user-stats/{user}', 'DashboardController@getUserStats');
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

Route::group(['middleware' => ['role:Administrador']], function(){
	Route::delete('supplier/{supplier}', 'SupplierController@destroy')->name('supplier.destroy');
});


//Admin
Route::group(['middleware' => ['role:Administrador']], function(){
	//User
	Route::get('user/get-list', 'UserController@getList');
	Route::resource('user', 'UserController');

	//Configuration
	Route::get('configuration', function(){
		return view('configuration.index');
	})->name('configuration.index');

	//ColorSettings
	Route::get('color-settings/edit', 'ColorSettingController@edit')->name('settings.edit');
	Route::post('color-settings', 'ColorSettingController@store')->name('settings.store');

	//Alerts
	Route::get('alert/get-list', 'AlertController@getList');
	Route::resource('alert', 'AlertController');
	
	//Messages
	Route::get('message/get-list', 'MessageController@getList');
	Route::resource('message', 'MessageController');

	//Report
	Route::post('report/download-pcts-pdf', 'ReportController@downloadPCTSPDF')->name('report.download-pcts-pdf');
	Route::post('report/download-pcts-excel', 'ReportController@downloadPCTSExcel')->name('report.download-pcts-excel');
	Route::get('report/get-list', 'ReportController@getList')->name('report.get-list');
	Route::get('report', 'ReportController@index')->name('report.index');
});

//Inbox
Route::get('inbox/get-list', 'InboxController@getList')->name('inbox.get-list');

Route::group(['middleware' => ['role:Administrador']], function(){
	Route::post('inbox/change-dealership', 'InboxController@changeDealerShip')->name('inbox.change-dealership');
	Route::post('inbox/{document}/archive-lock/{action}', 'InboxController@archiveOrLock');
});

Route::post('inbox/{document}/unlock', 'InboxController@unlock');
Route::get('inbox/document-supplies', 'InboxController@getDocumentSupplySets');
//jsanchez
Route::get('inbox/document-supplies-rows', 'InboxController@getDocumentSupplySetsRows');
//jsanchez
Route::get('inbox/document-binnacle/{documents_id}', 'InboxController@getDocumentBinnacle');
Route::get('inbox/get-set-tabs/{set_id}', 'InboxController@getSetTabs');
Route::get('inbox/get-volumetric-weight/{type}', 'InboxController@getVolumetricWeight');
Route::post('inbox/update-set-budget/{set_id}', 'InboxController@updateBudget')->name('inbox.update-set-budget');
Route::post('inbox/check-checklist-item', 'InboxController@checkChecklistItem');
Route::post('inbox/update-set-conditions/{set_id}', 'InboxController@updateConditions')->name('inbox.update-set-conditions');
Route::get('inbox/get-condition-value/{condition_id}/{field}', 'InboxController@getConditionValue');
Route::get('inbox/set-files/{set_id}', 'InboxController@getSetFiles');
Route::post('inbox/sets-file-attachment', 'InboxController@setsFileAttachment')->name('inbox.sets-file-attachment');
Route::get('inbox/document-sets-files/{document_id}', 'InboxController@getDocumentSetsFiles');
Route::delete('inbox/supply-file-delete/{supply_id}/{file_id}', 'InboxController@supplyFileDetach');
Route::get('inbox/get-manufacturer-suppliers-and-supplies/{documents_id}/{manufacturer_id}', 'InboxController@getManufacturerSuppliersAndSupplies');
Route::post('inbox/send-suppliers-quotation', 'InboxController@sendSuppliersQuotation')->name('inbox.send-suppliers-quotation');
Route::post('inbox/change-set-status', 'InboxController@changeSetStatus');
Route::post('inbox/reject-set', 'InboxController@rejectSet')->name('inbox.reject-set');
Route::post('inbox/sets-turn-ctz', 'InboxController@setsTurnCTZ')->name('inbox.sets-turn-ctz');
Route::post('inbox/binnacle-entry', 'InboxController@binnacleEntry')->name('inbox.binnacle-entry');
Route::resource('inbox', 'InboxController');

//Archive
Route::get('archive/get-list', 'ArchiveController@getList')->name('archive.get-list');
Route::resource('archive', 'ArchiveController');

//Supply set rejection
Route::get('rejection-reason/get-list', 'RejectionReasonController@getList');
Route::resource('rejection-reason', 'RejectionReasonController');

//Supplies/products
Route::get('supply/get-list', 'SupplyController@getList');
Route::get('supply/{supply_id}/get-replacements-observations/{type}', 'SupplyController@getReplacementsObservations');

Route::post('supply/store-replacement-observation/{type}', 'SupplyController@saveReplacementObservation');
Route::delete('supply/replacement-observation/{id}/{type}', 'SupplyController@deleteReplacementObservation');

Route::get('supply/{supply_id}/pcts', 'SupplyController@getPcts');
Route::get('supply/{supply_id}/binnacle', 'SupplyController@getBinnacle');
Route::get('supply', 'SupplyController@index')->name('supply.index');