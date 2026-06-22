<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelicula extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'peliculas';

    protected $fillable = [
        'titulo',
        'titulo_original',
        'descripcion',
        'sinopsis',
        'categoria_id',
        'director',
        'anio_lanzamiento',
        'duracion_minutos',
        'clasificacion',      // G, PG, PG-13, R, NC-17
        'idioma_original',
        'idiomas_disponibles', // JSON: ["Español","Inglés","Francés"]
        'subtitulos',          // JSON: ["Español","Inglés"]
        'formato',             // DVD, Blu-ray, 4K UHD, Digital
        'precio',
        'precio_alquiler',
        'stock',
        'imagen_portada',
        'imagen_fondo',
        'trailer_url',
        'calificacion_imdb',
        'calificacion_local',
        'destacado',
        'disponible',
        'fecha_disponibilidad',
    ];

    protected $casts = [
        'idiomas_disponibles' => 'array',
        'subtitulos'          => 'array',
        'precio'              => 'decimal:2',
        'precio_alquiler'     => 'decimal:2',
        'calificacion_imdb'   => 'decimal:1',
        'calificacion_local'  => 'decimal:1',
        'destacado'           => 'boolean',
        'disponible'          => 'boolean',
        'fecha_disponibilidad'=> 'date',
    ];

    // ─── Relaciones ──────────────────────────────────────────────

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function generos()
    {
        return $this->belongsToMany(Genero::class, 'pelicula_genero');
    }

    // ─── Scopes ──────────────────────────────────────────────────

    public function scopeDisponibles($query)
    {
        return $query->where('disponible', true)->where('stock', '>', 0);
    }

    public function scopeDestacados($query)
    {
        return $query->where('destacado', true);
    }

    public function scopePorCategoria($query, $categoriaId)
    {
        return $query->where('categoria_id', $categoriaId);
    }

    // ─── Accessors ───────────────────────────────────────────────
public function getImagenPortadaUrlAttribute(): string
{
    return asset('images/' . $this->id . '.jpg');
}

    public function getPrecioFormateadoAttribute(): string
    {
        return '₡' . number_format($this->precio, 0, ',', '.');
    }

    public function getCalificacionEstrellaAttribute(): string
    {
        $estrellas = round($this->calificacion_local / 2);
        return str_repeat('★', $estrellas) . str_repeat('☆', 5 - $estrellas);
    }
}
