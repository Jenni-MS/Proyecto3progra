<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    /**
     * GET /api/actores
     * Listar actores con paginación
     */
    public function index()
    {
        $actores = Actor::paginate(20);
        return response()->json($actores);
    }

    /**
     * GET /api/actores/{id}
     * Ver detalle de un actor con sus películas
     */
    public function show($id)
    {
        $actor = Actor::with('peliculas')->findOrFail($id);
        return response()->json($actor);
    }

    /**
     * GET /api/buscar/actores?q=termino
     * Buscar actores
     */
    public function buscar(Request $request)
    {
        $termino = $request->get('q', '');
        $actores = Actor::where('nombre', 'like', "%{$termino}%")
                        ->orWhere('apellidos', 'like', "%{$termino}%")
                        ->limit(10)
                        ->get();

        return response()->json($actores);
    }
}