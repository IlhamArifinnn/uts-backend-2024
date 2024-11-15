<?php

use App\Http\Controllers\PasienController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {


    Route::get('/pasiens/search/{name}', [PasienController::class, 'search']);

    Route::get('/pasiens', [PasienController::class, 'index']);
    Route::post('/pasiens', [PasienController::class, 'store']);
    Route::get('/pasiens/{id}', [PasienController::class, 'show']);
    Route::put('/pasiens/{id}', [PasienController::class, 'update']);
    Route::delete('/pasiens/{id}', [PasienController::class, 'destroy']);
});


use App\Http\Controllers\AuthController;

#Route Register dan login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
