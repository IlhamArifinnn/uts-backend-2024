<?php

use App\Http\Controllers\PasienController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

# Route Register dan login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Basic CRUD routes
    Route::get('/pasiens', [PasienController::class, 'index']);
    Route::post('/pasiens', [PasienController::class, 'store']);
    Route::get('/pasiens/{id}', [PasienController::class, 'show']);
    Route::put('/pasiens/{id}', [PasienController::class, 'update']);
    Route::delete('/pasiens/{id}', [PasienController::class, 'destroy']);

    // Search route
    Route::get('/pasiens/search/{name}', [PasienController::class, 'search']);

    // Status filter routes
    Route::get('/pasiens/status/positive', [PasienController::class, 'positive']);
    Route::get('/pasiens/status/recovered', [PasienController::class, 'recovered']);
    Route::get('/pasiens/status/dead', [PasienController::class, 'dead']);
});
