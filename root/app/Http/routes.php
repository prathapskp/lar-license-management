<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
// home controller
Route::get('/', 'HomeController@index');
//
//clients controller
Route::get('clients', 'ClientsController@index');
Route::get('clients/ajaxData', 'ClientsController@ajax_data');
Route::get('clients/create', 'ClientsController@create');
Route::post('clients/create', 'ClientsController@store');
Route::get('clients/edit/{id}', 'ClientsController@edit');
Route::post('clients/{id}/update',['as' => 'clients.update', 'uses' => 'ClientsController@Update']);
Route::get('clients/delete/{id}', 'ClientsController@destroy');
Route::get('client/dashboard', 'ClientsController@dashboard');
Route::get('client/vehicles', 'ClientsController@assigned_vehicles');
Route::get('client/ajaxVehicleData', 'ClientsController@ajax_vehicle_data');
Route::get('client/login', 'ClientsController@client_login');
Route::post('client/login', 'ClientsController@do_client_login');

//

//vehicle types
Route::get('vehicle-types', 'VehicleTypeController@index');
Route::get('vehicle-types/ajaxData', 'VehicleTypeController@ajax_data');
Route::get('vehicle-type/create', 'VehicleTypeController@create');
Route::post('vehicle-type/create', 'VehicleTypeController@store');
Route::get('vehicle-type/edit/{id}', 'VehicleTypeController@edit');
Route::post('vehicle-type/{id}/update',['as' => 'vehicle-type.update', 'uses' => 'VehicleTypeController@Update']);
Route::get('vehicle-type/delete/{id}', 'VehicleTypeController@destroy');
//

//license types
Route::get('license-types', 'LicenseTypeController@index');
Route::get('license-types/ajaxData', 'LicenseTypeController@ajax_data');
Route::get('license-type/create', 'LicenseTypeController@create');
Route::post('license-type/create', 'LicenseTypeController@store');
Route::get('license-type/edit/{id}', 'LicenseTypeController@edit');
Route::post('license-type/{id}/update',['as' => 'license-type.update', 'uses' => 'LicenseTypeController@Update']);
Route::get('license-type/delete/{id}', 'LicenseTypeController@destroy');
//

//vehicles
Route::get('vehicles', 'VehicleController@index');
Route::get('vehicles/ajaxData', 'VehicleController@ajax_data');
Route::get('vehicle/create', 'VehicleController@create');
Route::get('vehicle/ajaxGetLicenseTypes/{id}', 'VehicleController@ajax_get_license_types');
Route::post('vehicle/create', 'VehicleController@store');
Route::get('vehicle/edit/{id}', 'VehicleController@edit');
Route::post('vehicle/{id}/update',['as' => 'vehicle.update', 'uses' => 'VehicleController@Update']);
Route::get('vehicle/delete/{id}', 'VehicleController@destroy');
Route::get('vehicle/update-license/{page_type}/{id}', 'VehicleController@update_license');
Route::post('vehicle/store_license', 'VehicleController@store_license');
Route::post('vehicle/get_expiry_date', 'VehicleController@get_expiry_date');
Route::get('vehicle/renewal_request/{id}', 'VehicleController@renewal_request');
Route::post('vehicle/renewal_request', 'VehicleController@create_renewal_request');
Route::get('vehicle/renewal-listing', 'VehicleController@renewal_listing');
Route::get('vehicle/renewal_listing_ajax_data', 'VehicleController@renewal_listing_ajax_data');
Route::get('vehicle/renew-license/{page_type}/{id}', 'VehicleController@update_license');
//

//license notification
Route::get('notify', 'LicenseNotificationController@notify');
//
// user controller
Route::get('login', 'UserController@login');
Route::post('login', 'UserController@do_login');
Route::get('logout', 'UserController@do_logout');
Route::get('profile', 'UserController@edit');
Route::post('user/{id}/update',['as' => 'user.update', 'uses' => 'UserController@Update']);

Route::group(['prefix' => 'api'], function () {	
    Route::get('profile', 'UserController@edit');
    Route::get('profile/{id}', 'UserController@edit');
});

//