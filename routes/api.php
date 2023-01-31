<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
	'namespace'  => '\App\Http\Controllers\Auth'
],function(){
    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');
});
Route::group([
	'namespace'  => '\App\Http\Controllers\User'
],function(){
    Route::post('/validate/{id}', 'EmployeeController@validateUser');
    Route::post('/confirmation/{id}', 'EmployeeController@confirmUser');
});
Route::group([
	'namespace'  => '\App\Http\Controllers\User',
    'middleware' => 'auth:sanctum',
],function(){
    Route::post('/user', 'AdminController@getCurrentUser'); //works fot both admin and employee
    Route::post('/EditUser', 'AdminController@EditUser'); // same as above
    Route::post('/updatePassword', 'AdminController@updatePassword'); //same as above
    Route::post('/getAllAdmin', 'AdminController@getAllAdmin');
    Route::post('/addAdmin', 'AdminController@addAdmin');
    Route::post('/checkAdmin', 'AdminController@checkAdmin');
    Route::post('/getAllEmployee', 'EmployeeController@getAllEmployee');
    Route::post('/getEmployee', 'EmployeeController@getEmployee');
});
Route::group([
	'namespace'  => '\App\Http\Controllers\Company',
    'middleware' => 'auth:sanctum',
],function(){
    Route::post('/addCompany', 'CompanyController@addCompany');
    Route::post('/getAllCompanies', 'CompanyController@getAllCompanies');
    Route::post('/company/showDetail/{id}', 'CompanyController@showDetail');
    Route::post('/company/show/{id}', 'CompanyController@show');
    Route::post('/company/update/{id}', 'CompanyController@update');
    Route::post('/company/delete/{id}', 'CompanyController@delete');
    Route::post('/invite', 'CompanyController@invite');
    Route::post('/getCompany', 'CompanyController@getCompany');
});
Route::group([
	'namespace'  => '\App\Http\Controllers\Invitation',
    'middleware' => 'auth:sanctum',
],function(){
    Route::post('/getInvitation', 'InvitationController@getInvitation');
    Route::post('/changeStatus', 'InvitationController@changeStatus');
});
Route::group([
	'namespace'  => '\App\Http\Controllers\Historique',
    'middleware' => 'auth:sanctum',
],function(){
    Route::post('/getHistorique', 'HistoriqueController@getHistorique');
});
