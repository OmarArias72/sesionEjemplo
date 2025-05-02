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
        Schema::table('detalles_pedidos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pedido')->nullable();
            $table->foreign('id_pedido')->references('id_pedido')->on("pedidos")->onDelete("set null");
            $table->unsignedBigInteger('id_producto')->nullable();
            $table->foreign('id_producto')->references('id_producto')->on("productos")->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalles_pedidos', function (Blueprint $table) {
            $table->dropForeign("id_pedido");
            $table->dropColumn("id_pedido");
            $table->dropForeign("id_producto");
            $table->dropColumn("id_producto");
        });
    }
};
