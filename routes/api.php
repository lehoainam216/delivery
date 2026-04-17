<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\GasController;
use App\Http\Controllers\GasTypeController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ApiController::class)->group(function () {
    // #1. Check Login
    Route::post('/login', 'login'); // Check Login   

    Route::get('/customer', 'customer');
    Route::get('/priority', 'priority');
    Route::get('/gas', 'gas');
    Route::get('/gas_type', 'gas_type');
    Route::get('/warehouse', 'warehouse');
    Route::get('/status', 'status');
    Route::get('/driver/{warehoue_id}', 'driver');
    Route::get('/car/{warehoue_id}', 'car');
});

Route::prefix('orders')->controller(OrderController::class)->group(function () {
    Route::get('/list', 'list');
    Route::get('/create', 'add');
    Route::get('/{uuid}', 'detail');
    Route::get('/edit/{uuid}', 'edit');
    Route::post('/store', 'store');
    Route::post('/update/{uuid}', 'update');
    Route::post('/receive/{uuid}', 'receive');
    Route::post('/delete/{uuid}', 'delete');
        
});
Route::prefix('customers')->controller(CustomerController::class)->group(function () {
    Route::get('/', 'index');    
    Route::get('/list', 'list');
    Route::post('/store', 'store');
    Route::post('/update/{uuid}', 'update'); 
    Route::post('/delete/{uuid}', 'delete');
    Route::post('/hide/{uuid}', 'hide');
});
Route::prefix('cars')->controller(CarController::class)->group(function () {
    Route::get('/', 'index');    
    Route::get('/list', 'list');
    Route::post('/store', 'store');
    Route::post('/update/{uuid}', 'update');
    Route::post('/delete/{uuid}', 'delete');
    Route::post('/hide/{uuid}', 'hide');
});

Route::prefix('drivers')->controller(DriverController::class)->group(function () {
    Route::get('/', 'index');    
    Route::get('/list', 'list');
    Route::post('/store', 'store');
    Route::post('/update/{uuid}', 'update');
    Route::post('/delete/{uuid}', 'delete');
    Route::post('/hide/{uuid}', 'hide');
});

Route::prefix('gases')->controller(GasController::class)->group(function () {
    Route::get('/', 'index');    
    Route::get('/list', 'list');
    Route::post('/store', 'store');
    Route::post('/update/{uuid}', 'update');
    Route::post('/delete/{uuid}', 'delete');
    Route::post('/hide/{uuid}', 'hide');
});

Route::prefix('gas-types')->controller(GasTypeController::class)->group(function () {
    Route::get('/', 'index');    
    Route::get('/list', 'list');
    Route::post('/store', 'store');
    Route::post('/update/{uuid}', 'update');
    Route::post('/delete/{uuid}', 'delete');
    Route::post('/hide/{uuid}', 'hide');
});

Route::prefix('warehouses')->controller(WarehouseController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/list', 'list');
    Route::post('/store', 'store');
    Route::post('/update/{uuid}', 'update');
    Route::post('/delete/{uuid}', 'delete');
    Route::post('/hide/{uuid}', 'hide');
});

Route::prefix('priorities')->controller(PriorityController::class)->group(function () {
    Route::get('/', 'index');    
    Route::get('/list', 'list');
    Route::post('/store', 'store');
    Route::post('/update/{uuid}', 'update');
    Route::post('/delete/{uuid}', 'delete');
    Route::post('/hide/{uuid}', 'hide');
});
Route::prefix('roles')->controller(RoleController::class)->group(function () {
    Route::get('/', 'index');    
    Route::get('/list', 'list');
    Route::post('/store', 'store');
    Route::post('/update/{uuid}', 'update');
    Route::post('/delete/{uuid}', 'delete');
    Route::post('/hide/{uuid}', 'hide');
});
Route::prefix('users')->controller(UserController::class)->group(function () {
    Route::get('/', 'index');    
    Route::get('/list', 'list');
    Route::post('/store', 'store');
    Route::post('/update/{uuid}', 'update');
    Route::post('/delete/{uuid}', 'delete');
    Route::post('/hide/{uuid}', 'hide');
    Route::post('/reset/{id}', 'resetPassword');
});