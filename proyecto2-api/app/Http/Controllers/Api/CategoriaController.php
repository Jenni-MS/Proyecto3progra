<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * GET /api/categorias
     * Listar todas las categorías activas
     */
    public function index()
    {
        $categorias = Categoria::where('activa', true)
                               ->withCount('peliculas')
                               ->get();

        return response()->json($categorias);
    }

    /**
     * GET /api/categorias/{slug}
     * Ver una categoría con sus películas
     */
    public function show($slug)
    {
        $categoria = Categoria::where('slug', $slug)
                              ->where('activa', true)
                              ->firstOrFail();

        $peliculas = $categoria->peliculas()
                               ->disponibles()
                               ->with('generos')
                               ->paginate(12);

        return response()->json([
            'categoria' => $categoria,
            'peliculas' => $peliculas
        ]);
    }
}