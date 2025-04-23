<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id('id_categoria');
            $table->string('nombre_categoria',255);
            $table->string('descripcion',255);
            $table->unsignedBigInteger('id_padre')->nullable();
            $table->timestamps();

            // Definición de la llave foránea
            $table->foreign('id_padre')
                  ->references('id_categoria')
                  ->on('categorias')
                  ->onDelete('set null'); // o 'cascade' según tu necesidad
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
