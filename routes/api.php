<?php

use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\DriverController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\VehicleController;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('vehicles', [VehicleController::class, 'all']);
Route::get('drivers', [DriverController::class, 'all']);

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [UserController::class, 'fetch']);
    Route::post('user', [UserController::class, 'updateProfile']);
    Route::post('logout', [UserController::class, 'logout']);

    Route::get('booking', [BookingController::class, 'all']);
    Route::post('checkout', [BookingController::class, 'checkout']);
});
