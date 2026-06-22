<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Genero;
use App\Models\Pelicula;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
      
        // ─── Categorías ───────────────────────────────────────────
        $categorias = [
            ['nombre' => 'Acción',          'slug' => 'accion',          'icono' => 'fa-bolt'],
            ['nombre' => 'Comedia',          'slug' => 'comedia',         'icono' => 'fa-face-laugh'],
            ['nombre' => 'Drama',            'slug' => 'drama',           'icono' => 'fa-theater-masks'],
            ['nombre' => 'Terror',           'slug' => 'terror',          'icono' => 'fa-skull'],
            ['nombre' => 'Ciencia Ficción',  'slug' => 'ciencia-ficcion', 'icono' => 'fa-rocket'],
            ['nombre' => 'Animación',        'slug' => 'animacion',       'icono' => 'fa-wand-magic-sparkles'],
            ['nombre' => 'Documental',       'slug' => 'documental',      'icono' => 'fa-film'],
            ['nombre' => 'Romance',          'slug' => 'romance',         'icono' => 'fa-heart'],
            ['nombre' => 'Thriller',         'slug' => 'thriller',        'icono' => 'fa-eye'],
            ['nombre' => 'Familiar',         'slug' => 'familiar',        'icono' => 'fa-house'],
        ];

        foreach ($categorias as $cat) {
            Categoria::create(array_merge($cat, ['activa' => true]));
        }

        // ─── Géneros ─────────────────────────────────────────────
        $generos = ['Aventura', 'Fantasía', 'Suspenso', 'Misterio', 'Musical',
                    'Histórico', 'Bélico', 'Western', 'Deportivo', 'Biográfico'];

        foreach ($generos as $g) {
            Genero::create(['nombre' => $g, 'slug' => \Str::slug($g)]);
        }

        // ─── Películas (30 artículos) ─────────────────────────────
        $peliculas = [
            // Acción (id 1)
            ['titulo'=>'El Origen',              'director'=>'Christopher Nolan',  'anio'=>2010, 'cat'=>1, 'precio'=>8990,  'imdb'=>8.8, 'formato'=>'Blu-ray',  'dur'=>148, 'clasif'=>'PG-13'],
            ['titulo'=>'Mad Max: Fury Road',     'director'=>'George Miller',      'anio'=>2015, 'cat'=>1, 'precio'=>7990,  'imdb'=>8.1, 'formato'=>'4K UHD',   'dur'=>120, 'clasif'=>'R'],
            ['titulo'=>'John Wick',              'director'=>'Chad Stahelski',     'anio'=>2014, 'cat'=>1, 'precio'=>6990,  'imdb'=>7.4, 'formato'=>'Blu-ray',  'dur'=>101, 'clasif'=>'R'],

            // Comedia (id 2)
            ['titulo'=>'El Gran Lebowski',       'director'=>'Joel Coen',          'anio'=>1998, 'cat'=>2, 'precio'=>5990,  'imdb'=>8.1, 'formato'=>'DVD',      'dur'=>117, 'clasif'=>'R'],
            ['titulo'=>'Superbad',               'director'=>'Greg Mottola',       'anio'=>2007, 'cat'=>2, 'precio'=>4990,  'imdb'=>7.6, 'formato'=>'DVD',      'dur'=>113, 'clasif'=>'R'],
            ['titulo'=>'La Rosa Púrpura del Cairo','director'=>'Woody Allen',      'anio'=>1985, 'cat'=>2, 'precio'=>4490,  'imdb'=>7.6, 'formato'=>'DVD',      'dur'=>82,  'clasif'=>'PG'],

            // Drama (id 3)
            ['titulo'=>'El Padrino',             'director'=>'Francis Ford Coppola','anio'=>1972,'cat'=>3, 'precio'=>9990,  'imdb'=>9.2, 'formato'=>'4K UHD',   'dur'=>175, 'clasif'=>'R'],
            ['titulo'=>'Forrest Gump',           'director'=>'Robert Zemeckis',    'anio'=>1994, 'cat'=>3, 'precio'=>7990,  'imdb'=>8.8, 'formato'=>'Blu-ray',  'dur'=>142, 'clasif'=>'PG-13'],
            ['titulo'=>'Boyhood',                'director'=>'Richard Linklater',  'anio'=>2014, 'cat'=>3, 'precio'=>6490,  'imdb'=>7.9, 'formato'=>'Blu-ray',  'dur'=>165, 'clasif'=>'R'],

            // Terror (id 4)
            ['titulo'=>'El Resplandor',          'director'=>'Stanley Kubrick',    'anio'=>1980, 'cat'=>4, 'precio'=>7490,  'imdb'=>8.4, 'formato'=>'4K UHD',   'dur'=>146, 'clasif'=>'R'],
            ['titulo'=>'Hereditary',             'director'=>'Ari Aster',          'anio'=>2018, 'cat'=>4, 'precio'=>6990,  'imdb'=>7.3, 'formato'=>'Blu-ray',  'dur'=>127, 'clasif'=>'R'],
            ['titulo'=>'Get Out',                'director'=>'Jordan Peele',       'anio'=>2017, 'cat'=>4, 'precio'=>6490,  'imdb'=>7.7, 'formato'=>'Blu-ray',  'dur'=>104, 'clasif'=>'R'],

            // Ciencia Ficción (id 5)
            ['titulo'=>'2001: Odisea del Espacio','director'=>'Stanley Kubrick',   'anio'=>1968, 'cat'=>5, 'precio'=>8490,  'imdb'=>8.3, 'formato'=>'4K UHD',   'dur'=>149, 'clasif'=>'G'],
            ['titulo'=>'Blade Runner 2049',      'director'=>'Denis Villeneuve',   'anio'=>2017, 'cat'=>5, 'precio'=>8990,  'imdb'=>8.0, 'formato'=>'4K UHD',   'dur'=>164, 'clasif'=>'R'],
            ['titulo'=>'Interstellar',           'director'=>'Christopher Nolan',  'anio'=>2014, 'cat'=>5, 'precio'=>9490,  'imdb'=>8.7, 'formato'=>'4K UHD',   'dur'=>169, 'clasif'=>'PG-13'],
            ['titulo'=>'Arrival',                'director'=>'Denis Villeneuve',   'anio'=>2016, 'cat'=>5, 'precio'=>7490,  'imdb'=>7.9, 'formato'=>'Blu-ray',  'dur'=>116, 'clasif'=>'PG-13'],

            // Animación (id 6)
            ['titulo'=>'El Viaje de Chihiro',   'director'=>'Hayao Miyazaki',     'anio'=>2001, 'cat'=>6, 'precio'=>8990,  'imdb'=>8.6, 'formato'=>'Blu-ray',  'dur'=>125, 'clasif'=>'PG'],
            ['titulo'=>'WALL-E',                 'director'=>'Andrew Stanton',     'anio'=>2008, 'cat'=>6, 'precio'=>7490,  'imdb'=>8.4, 'formato'=>'Blu-ray',  'dur'=>98,  'clasif'=>'G'],
            ['titulo'=>'Spider-Man: Un Nuevo Universo','director'=>'Bob Persichetti','anio'=>2018,'cat'=>6,'precio'=>8490,  'imdb'=>8.4, 'formato'=>'4K UHD',   'dur'=>117, 'clasif'=>'PG'],

            // Documental (id 7)
            ['titulo'=>'Planeta Tierra II',      'director'=>'David Attenborough', 'anio'=>2016, 'cat'=>7, 'precio'=>5990,  'imdb'=>9.5, 'formato'=>'4K UHD',   'dur'=>240, 'clasif'=>'G'],
            ['titulo'=>'Amy',                    'director'=>'Asif Kapadia',       'anio'=>2015, 'cat'=>7, 'precio'=>4990,  'imdb'=>7.8, 'formato'=>'Blu-ray',  'dur'=>128, 'clasif'=>'R'],

            // Romance (id 8)
            ['titulo'=>'Eternal Sunshine of the Spotless Mind','director'=>'Michel Gondry','anio'=>2004,'cat'=>8,'precio'=>6990,'imdb'=>8.3,'formato'=>'Blu-ray','dur'=>108,'clasif'=>'R'],
            ['titulo'=>'Antes del Amanecer',     'director'=>'Richard Linklater',  'anio'=>1995, 'cat'=>8, 'precio'=>5490,  'imdb'=>8.1, 'formato'=>'DVD',      'dur'=>101, 'clasif'=>'R'],

            // Thriller (id 9)
            ['titulo'=>'Se7en',                  'director'=>'David Fincher',      'anio'=>1995, 'cat'=>9, 'precio'=>7490,  'imdb'=>8.6, 'formato'=>'Blu-ray',  'dur'=>127, 'clasif'=>'R'],
            ['titulo'=>'Primal Fear',            'director'=>'Gregory Hoblit',     'anio'=>1996, 'cat'=>9, 'precio'=>5990,  'imdb'=>7.7, 'formato'=>'DVD',      'dur'=>129, 'clasif'=>'R'],
            ['titulo'=>'Parasite',               'director'=>'Bong Joon-ho',       'anio'=>2019, 'cat'=>9, 'precio'=>8490,  'imdb'=>8.5, 'formato'=>'4K UHD',   'dur'=>132, 'clasif'=>'R'],
            ['titulo'=>'La Red Social',          'director'=>'David Fincher',      'anio'=>2010, 'cat'=>9, 'precio'=>6990,  'imdb'=>7.7, 'formato'=>'Blu-ray',  'dur'=>120, 'clasif'=>'PG-13'],

            // Familiar (id 10)
            ['titulo'=>'Coco',                   'director'=>'Lee Unkrich',        'anio'=>2017, 'cat'=>10,'precio'=>8490,  'imdb'=>8.4, 'formato'=>'4K UHD',   'dur'=>105, 'clasif'=>'PG'],
            ['titulo'=>'La Princesa Mononoke',   'director'=>'Hayao Miyazaki',     'anio'=>1997, 'cat'=>10,'precio'=>7990,  'imdb'=>8.4, 'formato'=>'Blu-ray',  'dur'=>134, 'clasif'=>'PG-13'],
            ['titulo'=>'E.T. El Extraterrestre', 'director'=>'Steven Spielberg',   'anio'=>1982, 'cat'=>10,'precio'=>6490,  'imdb'=>7.9, 'formato'=>'Blu-ray',  'dur'=>115, 'clasif'=>'PG'],
            ['titulo'=>'La Historia Sin Fin',    'director'=>'Wolfgang Petersen',  'anio'=>1984, 'cat'=>10,'precio'=>5490,  'imdb'=>7.4, 'formato'=>'DVD',      'dur'=>102, 'clasif'=>'PG'],
        ];

        foreach ($peliculas as $p) {
            Pelicula::create([
                'titulo'            => $p['titulo'],
                'director'          => $p['director'],
                'anio_lanzamiento'  => $p['anio'],
                'categoria_id'      => $p['cat'],
                'precio'            => $p['precio'],
                'precio_alquiler'   => round($p['precio'] * 0.15, -1), // 15% del precio
                'calificacion_imdb' => $p['imdb'],
                'calificacion_local'=> $p['imdb'],
                'duracion_minutos'  => $p['dur'],
                'clasificacion'     => $p['clasif'],
                'formato'           => $p['formato'],
                'idioma_original'   => 'Inglés',
                'idiomas_disponibles'=> ['Español', 'Inglés'],
                'subtitulos'        => ['Español'],
                'descripcion'       => "Película dirigida por {$p['director']} ({$p['anio']}).",
                'stock'             => rand(5, 30),
                'disponible'        => true,
                'destacado'         => $p['imdb'] >= 8.5,
            ]);
        }
    }
}
