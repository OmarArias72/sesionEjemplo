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
        Schema::table('pedidos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->foreign('id_usuario')->references('id_usuario')->on("usuarios")->onDelete("set null");
            $table->unsignedBigInteger('id_direccion')->nullable();
            $table->foreign('id_direccion')->references('id_direccion')->on("direcciones")->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropForeign("id_usuario");
            $table->dropColumn("id_usuario");
            $table->dropForeign("id_direccion");
            $table->dropColumn("id_direccion");
        });
    }
};
