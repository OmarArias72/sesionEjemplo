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
        Schema::create('envios', function (Blueprint $table) {
            $table->id('id_envio');
            $table->string("estado",100);
            $table->string("codigoSeguimiento");
            $table->timestamp("fechaEnvio");
            $table->timestamp("fechaEstimadaEntrega");
            $table->timestamp("fechaEntrega");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('envios');
    }
};
