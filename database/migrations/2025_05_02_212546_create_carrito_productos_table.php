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
        Schema::create('carrito_productos', function (Blueprint $table) {
            $table->id('id_carrito_producto');
            $table->foreignId('id_carrito')->constrained('carritos', 'id_carrito')->onDelete('cascade');
            $table->foreignId('id_producto')->constrained('productos', 'id_producto')->onDelete('cascade');
            $table->integer('cantidad')->default(1);
            $table->decimal('precio_unitario', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrito_productos');
    }
};
