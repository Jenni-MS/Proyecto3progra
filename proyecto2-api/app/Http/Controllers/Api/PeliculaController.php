<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelicula;
use App\Models\Categoria;
use App\Models\Genero;
use Illuminate\Http\Request;

class PeliculaController extends Controller
{
    /**
     * GET /api/peliculas
     * Listar películas con filtros y paginación
     */
    public function index(Request $request)
    {
        $query = Pelicula::with(['categoria', 'generos'])
                         ->disponibles();

        // Filtros
        if ($request->filled('categoria')) {
            $query->whereHas('categoria', fn($q) =>
                $q->where('slug', $request->categoria)
            );
        }

        if ($request->filled('genero')) {
            $query->whereHas('generos', fn($q) =>
                $q->where('slug', $request->genero)
            );
        }

        if ($request->filled('formato')) {
            $query->where('formato', $request->formato);
        }

        if ($request->filled('precio_min')) {
            $query->where('precio', '>=', $request->precio_min);
        }
        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->precio_max);
        }

        // Búsqueda por texto
        if ($request->filled('buscar')) {
            $termino = $request->buscar;
            $query->where(function ($q) use ($termino) {
                $q->where('titulo', 'like', "%{$termino}%")
                  ->orWhere('director', 'like', "%{$termino}%")
                  ->orWhere('sinopsis', 'like', "%{$termino}%");
            });
        }

        // Ordenamiento
        switch ($request->get('orden', 'reciente')) {
            case 'precio_asc':
                $query->orderBy('precio', 'asc');
                break;
            case 'precio_desc':
                $query->orderBy('precio', 'desc');
                break;
            case 'titulo':
                $query->orderBy('titulo', 'asc');
                break;
            case 'calificacion':
                $query->orderBy('calificacion_imdb', 'desc');
                break;
            default:
                $query->latest();
        }

        $peliculas = $query->paginate(12);

        return response()->json($peliculas);
    }

    /**
     * GET /api/peliculas/destacadas
     * Películas destacadas para el home
     */
    public function destacadas()
    {
        $peliculas = Pelicula::with('categoria')
                            ->destacados()
                            ->disponibles()
                            ->limit(6)
                            ->get();

        return response()->json($peliculas);
    }

    /**
     * GET /api/peliculas/recientes
     * Películas recientes
     */
    public function recientes()
    {
        $peliculas = Pelicula::with('categoria')
                            ->disponibles()
                            ->latest()
                            ->limit(8)
                            ->get();

        return response()->json($peliculas);
    }

    /**
     * GET /api/peliculas/en-oferta
     * Películas en oferta (con precio de alquiler)
     */
    public function enOferta()
    {
        $peliculas = Pelicula::disponibles()
                            ->whereNotNull('precio_alquiler')
                            ->inRandomOrder()
                            ->limit(4)
                            ->get();

        return response()->json($peliculas);
    }

    /**
     * GET /api/peliculas/{id}
     * Ver detalle de una película
     */
    public function show($id)
    {
        $pelicula = Pelicula::with(['categoria', 'generos'])->findOrFail($id);

        // Películas relacionadas (misma categoría)
        $relacionadas = Pelicula::disponibles()
            ->where('categoria_id', $pelicula->categoria_id)
            ->where('id', '!=', $pelicula->id)
            ->limit(4)
            ->get();

        return response()->json([
            'pelicula' => $pelicula,
            'relacionadas' => $relacionadas
        ]);
    }

    /**
     * POST /api/peliculas
     * Crear nueva película
     */
    public function store(Request $request)
    {
        $data = $this->validar($request);

        $data['idiomas_disponibles'] = $this->parseLista($request->idiomas_disponibles);
        $data['subtitulos'] = $this->parseLista($request->subtitulos);
        $data['destacado'] = $request->boolean('destacado');
        $data['disponible'] = $request->boolean('disponible');

        $pelicula = Pelicula::create($data);

        if ($request->filled('generos')) {
            $pelicula->generos()->sync($request->generos);
        }

        return response()->json($pelicula, 201);
    }

    /**
     * PUT /api/peliculas/{id}
     * Actualizar película
     */
    public function update(Request $request, $id)
    {
        $pelicula = Pelicula::findOrFail($id);

        $data = $this->validar($request, $pelicula->id);

        $data['idiomas_disponibles'] = $this->parseLista($request->idiomas_disponibles);
        $data['subtitulos'] = $this->parseLista($request->subtitulos);
        $data['destacado'] = $request->boolean('destacado');
        $data['disponible'] = $request->boolean('disponible');

        $pelicula->update($data);
        $pelicula->generos()->sync($request->generos ?? []);

        return response()->json($pelicula);
    }

    /**
     * DELETE /api/peliculas/{id}
     * Eliminar película (soft delete)
     */
    public function destroy($id)
    {
        $pelicula = Pelicula::findOrFail($id);
        $pelicula->delete();

        return response()->json(null, 204);
    }

    /**
     * GET /api/buscar?q=termino
     * Búsqueda rápida para autocompletado
     */
    public function buscar(Request $request)
    {
        $termino = $request->get('q', '');

        $resultados = Pelicula::disponibles()
            ->where('titulo', 'like', "%{$termino}%")
            ->select('id', 'titulo', 'anio_lanzamiento', 'imagen_portada', 'precio')
            ->limit(8)
            ->get();

        return response()->json($resultados);
    }

    /**
     * GET /api/peliculas/filtros
     * Obtener valores para filtros (categorías, géneros, formatos)
     */
    public function filtros()
    {
        return response()->json([
            'categorias' => Categoria::where('activa', true)->get(['id', 'nombre', 'slug']),
            'generos' => Genero::orderBy('nombre')->get(['id', 'nombre', 'slug']),
            'formatos' => ['DVD', 'Blu-ray', '4K UHD', 'Digital'],
            'clasificaciones' => ['G', 'PG', 'PG-13', 'R', 'NC-17']
        ]);
    }

    // ─── Métodos privados ───
    private function validar(Request $request, ?int $ignorarId = null): array
    {
        return $request->validate([
            'titulo' => 'required|string|max:200',
            'titulo_original' => 'nullable|string|max:200',
            'descripcion' => 'required|string',
            'sinopsis' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'director' => 'required|string|max:150',
            'anio_lanzamiento' => 'required|integer|min:1888|max:' . (date('Y') + 2),
            'duracion_minutos' => 'required|integer|min:1|max:999',
            'clasificacion' => 'required|in:G,PG,PG-13,R,NC-17',
            'idioma_original' => 'required|string|max:60',
            'formato' => 'required|in:DVD,Blu-ray,4K UHD,Digital',
            'precio' => 'required|numeric|min:0',
            'precio_alquiler' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen_portada' => 'nullable|string|max:500',
            'trailer_url' => 'nullable|url|max:500',
            'calificacion_imdb' => 'nullable|numeric|min:0|max:10',
            'calificacion_local' => 'nullable|numeric|min:0|max:10',
            'fecha_disponibilidad' => 'nullable|date',
        ]);
    }

    private function parseLista(?string $valor): ?array
    {
        if (empty($valor)) return null;
        return array_values(array_filter(array_map('trim', explode(',', $valor))));
    }
}