<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'apellidos', 'nacionalidad', 'foto', 'biografia'];

    public function peliculas()
    {
        return $this->belongsToMany(Pelicula::class, 'pelicula_actor')
                    ->withPivot('papel', 'orden_credito');
    }

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellidos}";
    }
}
