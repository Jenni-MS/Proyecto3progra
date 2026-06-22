<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'slug', 'descripcion', 'icono', 'activa'];

    protected $casts = ['activa' => 'boolean'];

    public function peliculas()
    {
        return $this->hasMany(Pelicula::class);
    }

    // Ejemplo de valores: Acción, Comedia, Drama, Terror, Ciencia Ficción,
    //                     Animación, Documental, Romance, Thriller, Familiar
}
