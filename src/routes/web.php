<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;

// Ruta de la página de inicio
Route::get('/',  [IndexController::class, 'index'])->name('index');

// Rutas de login-logout.
Route::post('/loginPost', [LoginController::class, 'loginPost']);
Route::post('/registerPost', [LoginController::class, 'registerPost']);
Route::get('/logout', [LogoutController::class, 'logout'])->middleware('auth')->name('logout');

// Rutas de usuario.
Route::get('/user-edit', [UserController::class, 'userEdit']);
Route::post('/user-save', [UserController::class, 'userSave']);

// Rutas del calendario
Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario');
Route::get('/inscripcion/{id}', [CalendarioController::class, 'inscripcion'])->name('inscripcion');
Route::get('/desuscripcion/{id}', [CalendarioController::class, 'desuscripcion'])->name('desuscripcion');

// Rutas de administrador
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard')->middleware('auth');

// Rutas de acto
Route::get('/acto-edit/{id?}', [AdminController::class, 'actoEdit']);
Route::post('/acto-save', [AdminController::class, 'actoSave']);
Route::get('/acto-delete/{id}', [AdminController::class, 'actoDelete']);

// Rutas de ponente
Route::get('/ponente-list/{id?}', [AdminController::class, 'ponenteList'])->name('ponente-list');
Route::get('/ponente-add/{id?}', [AdminController::class, 'ponenteAdd']);
Route::post('/ponente-save', [AdminController::class, 'ponenteSave']);
Route::get('/ponente-delete/{id}', [AdminController::class, 'ponenteDelete']);

// Rutas de tipo de acto
Route::get('/tipoacto-edit/{id?}', [AdminController::class, 'tipoActoEdit']);
Route::post('/tipoacto-save', [AdminController::class, 'tipoActoSave']);
Route::get('/tipoacto-delete/{id}', [AdminController::class, 'tipoActoDelete']);

// Rutas de inscritos
Route::get('/inscritos-list/{id?}', [AdminController::class, 'inscritosList'])->name('inscritos-list');
Route::get('/inscritos-add/{id?}', [AdminController::class, 'inscritosAdd']);
Route::post('/inscritos-save', [AdminController::class, 'inscritosSave']);
Route::get('/inscritos-delete/{id}', [AdminController::class, 'inscritosDelete']);




