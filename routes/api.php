<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['as' => 'api.'], function () {
    Route::get('users', 'API\\UserAPIController@index');
    Route::get('providers/datatable', 'ProviderController@datatables')->name('providers.datatables');

    Route::post('costcentres/{costCentre}/members', 'API\\CostCentreAPIController@addReviewer');
    Route::delete('costcentres/{costCentre}/members/{user}', 'API\\CostCentreAPIController@removeReviewer');
});
