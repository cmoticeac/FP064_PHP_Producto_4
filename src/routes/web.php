<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CalendarioController;

// Rutas de usuario
Route::post('/Dashboard', [UserController::class, 'dashboard']);
Route::post('/loginPost', [UserController::class, 'loginPost']);
Route::post('/registerPost', [UserController::class, 'registerPost']);
Route::get('/logout', [UserController::class, 'logout']);
Route::get('/user-edit', [UserController::class, 'userEdit']);
Route::post('/user-save', [UserController::class, 'userSave']);

// Rutas de administrador
Route::get('/tipoacto-edit', [AdminController::class, 'tipoActoEdit']);
Route::post('/tipoacto-save', [AdminController::class, 'tipoActoSave']);
Route::get('/tipoacto-delete/{id}', [AdminController::class, 'tipoActoDelete']);

Route::get('/ponente-edit', [AdminController::class, 'ponenteList']);
Route::post('/ponente-save', [AdminController::class, 'ponenteSave']);
Route::get('/ponente-delete/{id}', [AdminController::class, 'ponenteDelete']);
Route::get('/ponente-add/{id}', [AdminController::class, 'ponenteAdd']);

Route::get('/acto-edit', [AdminController::class, 'actoEdit']);
Route::post('/acto-save', [AdminController::class, 'actoSave']);
Route::get('/acto-delete/{id}', [AdminController::class, 'actoDelete']);

// Rutas del calendario
Route::get('/calendario', [CalendarioController::class, 'index']);
Route::post('/inscripcion', [CalendarioController::class, 'inscripcion']);
Route::post('/desuscripcion', [CalendarioController::class, 'desuscripcion']);

// Ruta de la página de inicio
Route::get('/', function () {
    return view('index');
});
