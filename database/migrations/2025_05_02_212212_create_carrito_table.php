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
        Schema::create('carritos', function (Blueprint $table) {
            $table->id('id_carrito');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->onDelete('cascade');
            $table->timestamp('fecha_creacion')->nullable();
            $table->timestamp('fecha_actualizacion')->nullable();
            $table->enum('estado', ['activo', 'convertido_en_pedido', 'cancelado','completado'])->default('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrito');
    }
};
