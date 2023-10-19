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

Route::resource('blogs', BlogController::class)->except('store', 'update', 'destroy');
/**
 * GET api/blogs
 * GET api/blogs/{id}
 */


Route::post('login', [AuthController::class, 'authLogin']); /* POST api/login */
Route::post('register', [RegisterController::class, 'authRegister']); /* POST api/register */

// only authenticated users can access these routes
Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('logout', [AuthController::class, 'authLogout']); /* POST api/logout */
    Route::post('create', [BlogController::class, 'store']); /* POST api/create */
    Route::post('delete/{id}', [BlogController::class, 'destroy']); /* POST api/delete/{id} */
    Route::put('update/{id}', [BlogController::class, 'update']); /* PUT api/update/{id} */
    Route::get('dashboard', [DashboardController::class, 'dashboard']); /* GET api/dashboard */
});
