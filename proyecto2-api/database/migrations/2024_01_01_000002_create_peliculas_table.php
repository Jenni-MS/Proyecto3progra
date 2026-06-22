<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peliculas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias')->restrictOnDelete();

            // Información principal
            $table->string('titulo', 200);
            $table->string('titulo_original', 200)->nullable();
            $table->text('descripcion');
            $table->longText('sinopsis')->nullable();
            $table->string('director', 150);
            $table->year('anio_lanzamiento');
            $table->unsignedSmallInteger('duracion_minutos');

            // Clasificación y formatos
            $table->enum('clasificacion', ['G', 'PG', 'PG-13', 'R', 'NC-17'])->default('PG');
            $table->string('idioma_original', 60)->default('Inglés');
            $table->json('idiomas_disponibles')->nullable();   // ["Español","Inglés"]
            $table->json('subtitulos')->nullable();            // ["Español","Inglés"]
            $table->enum('formato', ['DVD', 'Blu-ray', '4K UHD', 'Digital'])->default('Blu-ray');

            // Precios e inventario
            $table->decimal('precio', 8, 2);                  // precio de venta
            $table->decimal('precio_alquiler', 7, 2)->nullable(); // precio de alquiler
            $table->unsignedInteger('stock')->default(0);

            // Multimedia
            $table->string('imagen_portada')->nullable();      // ruta en storage
            $table->string('imagen_fondo')->nullable();
            $table->string('trailer_url', 500)->nullable();    // URL YouTube

            // Calificaciones
            $table->decimal('calificacion_imdb', 3, 1)->nullable();  // 0.0–10.0
            $table->decimal('calificacion_local', 3, 1)->default(0); // 0.0–10.0

            // Estado
            $table->boolean('destacado')->default(false);
            $table->boolean('disponible')->default(true);
            $table->date('fecha_disponibilidad')->nullable();

            $table->softDeletes();
            $table->timestamps();

            // Índices para búsqueda
            $table->index(['categoria_id', 'disponible']);
            $table->index('anio_lanzamiento');
            $table->index('destacado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peliculas');
    }
};
