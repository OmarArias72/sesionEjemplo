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
        Schema::table('envios', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pedido')->nullable();
            $table->foreign('id_pedido')->references('id_pedido')->on("pedidos")->onDelete("set null");
            $table->unsignedBigInteger('id_empresa')->nullable();
            $table->foreign('id_empresa')->references('id_empresa')->on("empresas_envio")->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('envios', function (Blueprint $table) {
            $table->dropForeign("id_pedido");
            $table->dropColumn("id_pedido");
            $table->dropForeign("id_empresa");
            $table->dropColumn("id_empresa");
        });
    }
};
