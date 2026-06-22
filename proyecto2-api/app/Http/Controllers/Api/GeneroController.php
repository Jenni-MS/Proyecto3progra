<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genero;
use Illuminate\Http\Request;

class GeneroController extends Controller
{
    /**
     * GET /api/generos
     * Listar todos los géneros
     */
    public function index()
    {
        $generos = Genero::orderBy('nombre')
                         ->withCount('peliculas')
                         ->get();

        return response()->json($generos);
    }

    /**
     * GET /api/generos/{slug}/peliculas
     * Películas de un género específico
     */
    public function peliculas($slug)
    {
        $genero = Genero::where('slug', $slug)->firstOrFail();

        $peliculas = $genero->peliculas()
                            ->disponibles()
                            ->with('categoria')
                            ->paginate(12);

        return response()->json([
            'genero' => $genero,
            'peliculas' => $peliculas
        ]);
    }
}