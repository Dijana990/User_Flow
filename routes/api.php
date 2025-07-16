<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/users', [UserController::class, 'index']); // Dohvat svih korisnika
    Route::post('/users', [UserController::class, 'store']); // Dodavanje novog korisnika
    Route::put('/users/{id}', [UserController::class, 'update']); // Update korisnika
    Route::delete('/users/{id}', [UserController::class, 'destroy']); // Brisanje korisnika

    Route::get('/users/count', [UserController::class, 'count']);
    Route::get('/users/admins/count', [UserController::class, 'countAdmins']);
});

