<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\TrashedController;

// Ruta principal
Route::get('/', function () {
    return view('welcome');
});

// Rutas de recursos
Route::resource('mascotas', MascotaController::class);
Route::resource('servicios', ServicioController::class);
Route::resource('citas', CitaController::class);

// Rutas para elementos eliminados (trashed)
Route::get('/trashed', [TrashedController::class, 'index'])->name('trashed.index');

// Rutas para restaurar elementos eliminados
Route::post('/mascotas/{id}/restore', [MascotaController::class, 'restore'])->name('mascotas.restore');
Route::post('/servicios/{id}/restore', [ServicioController::class, 'restore'])->name('servicios.restore');
Route::post('/citas/{id}/restore', [CitaController::class, 'restore'])->name('citas.restore');
