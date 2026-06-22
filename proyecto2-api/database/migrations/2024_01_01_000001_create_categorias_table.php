<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('slug', 120)->unique();
            $table->text('descripcion')->nullable();
            $table->string('icono', 50)->nullable();   // p.ej. clase FontAwesome
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });

        // Categorías base (formato: nombre => slug)
        // Acción, Comedia, Drama, Terror, Ciencia Ficción,
        // Animación, Documental, Romance, Thriller, Familiar
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
