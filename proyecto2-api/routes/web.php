<?php

use App\Http\Controllers\Api\PeliculaController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\GeneroController;
use App\Http\Controllers\Api\ActorController;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::get('peliculas', [PeliculaController::class, 'index']);
Route::get('peliculas/destacadas', [PeliculaController::class, 'destacadas']);
Route::get('peliculas/recientes', [PeliculaController::class, 'recientes']);
Route::get('peliculas/en-oferta', [PeliculaController::class, 'enOferta']);
Route::get('peliculas/filtros', [PeliculaController::class, 'filtros']);
Route::get('peliculas/{id}', [PeliculaController::class, 'show']);
Route::get('buscar', [PeliculaController::class, 'buscar']);

Route::get('categorias', [CategoriaController::class, 'index']);
Route::get('categorias/{slug}', [CategoriaController::class, 'show']);

Route::get('generos', [GeneroController::class, 'index']);
Route::get('generos/{slug}/peliculas', [GeneroController::class, 'peliculas']);

Route::get('actores', [ActorController::class, 'index']);
Route::get('actores/{id}', [ActorController::class, 'show']);
Route::get('buscar/actores', [ActorController::class, 'buscar']);

Route::middleware('verify.token')->group(function () {
    Route::post('peliculas', [PeliculaController::class, 'store']);
    Route::put('peliculas/{id}', [PeliculaController::class, 'update']);
    Route::delete('peliculas/{id}', [PeliculaController::class, 'destroy']);
});