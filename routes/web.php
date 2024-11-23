<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\CitaController;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('mascotas', MascotaController::class);
Route::resource('servicios', ServicioController::class);
Route::resource('citas', CitaController::class);
