<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ─── Géneros ─────────────────────────────────────────────
        Schema::create('generos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 80)->unique();
            $table->string('slug', 100)->unique();
            $table->timestamps();
        });

        // ─── Actores ─────────────────────────────────────────────
        Schema::create('actores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('apellidos', 150);
            $table->string('nacionalidad', 80)->nullable();
            $table->string('foto')->nullable();
            $table->text('biografia')->nullable();
            $table->timestamps();
        });

        // ─── Pivot: Película – Género ─────────────────────────────
        Schema::create('pelicula_genero', function (Blueprint $table) {
            $table->foreignId('pelicula_id')->constrained('peliculas')->cascadeOnDelete();
            $table->foreignId('genero_id')->constrained('generos')->cascadeOnDelete();
            $table->primary(['pelicula_id', 'genero_id']);
        });

        // ─── Pivot: Película – Actor ──────────────────────────────
        Schema::create('pelicula_actor', function (Blueprint $table) {
            $table->foreignId('pelicula_id')->constrained('peliculas')->cascadeOnDelete();
            $table->foreignId('actor_id')->constrained('actores')->cascadeOnDelete();
            $table->string('papel', 120)->nullable();          // nombre del personaje
            $table->unsignedTinyInteger('orden_credito')->default(99);
            $table->primary(['pelicula_id', 'actor_id']);
        });


    }

    public function down(): void
    {
        Schema::dropIfExists('pelicula_actor');
        Schema::dropIfExists('pelicula_genero');
        Schema::dropIfExists('actores');
        Schema::dropIfExists('generos');
    }
};
