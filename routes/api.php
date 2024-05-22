<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;



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
Route::get("/test-me", function () {
    return 'Hello from Laravel!';
});
// Login route
Route::post('/login', [AuthController::class, 'login']);

// Register route
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Route::middleware(['auth:sanctum', 'admin'])->group(function () {
//     Route::get('/admin');
//     Route::get('/home', [AdminController::class, 'home']);
//     // Add more routes here...
// });
// Route::middleware(['auth:sanctum', 'admin'])->get('/admin');
// Route::middleware(['auth:sanctum', 'admin'])->get('/home');
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/admin/home', [AdminController::class, 'home']);
});
// Route::get('/admin/home', [AdminController::class, 'home']);


Route::middleware('auth:sanctum', 'member')->get('/member', [UserController::class, 'dashboard']);


