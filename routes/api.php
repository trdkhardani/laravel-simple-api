<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::prefix('v1')->as('v1.')->middleware('auth:sanctum')

Route::resource('blogs', BlogController::class);
// Route::post('blogs', [BlogController::class, 'store']);
Route::post('login', [AuthController::class, 'authLogin']);
Route::post('register', [RegisterController::class, 'authRegister']);
Route::post('logout', [AuthController::class, 'authLogout'])->middleware('auth:sanctum');
Route::get('dashboard', [DashboardController::class, 'dashboard'])->middleware('auth:sanctum');
