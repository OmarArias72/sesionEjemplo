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
        Schema::create('empresas_envio', function (Blueprint $table) {
            $table->id('id_empresa');
            $table->string("nombreContacto");
            $table->string("numeroContacto");
            $table->string("correo");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas_envio');
    }
};
