<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ExpenseController;
use App\Http\Middleware\OwnerCheckMiddleware;
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

Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/despesas', [ExpenseController::class, 'index']);
    Route::get('/despesa/{id}', [ExpenseController::class, 'show'])->middleware(OwnerCheckMiddleware::class);
    Route::post('/despesa', [ExpenseController::class, 'store']);
    Route::delete('/despesa/{id}', [ExpenseController::class, 'destroy'])->middleware(OwnerCheckMiddleware::class);
    Route::put('/despesa/{id}', [ExpenseController::class, 'update'])->middleware(OwnerCheckMiddleware::class);
});
