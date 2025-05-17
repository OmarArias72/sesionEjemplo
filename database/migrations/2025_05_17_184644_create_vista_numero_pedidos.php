<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up()
    {
        DB::statement("
            CREATE VIEW numero_pedidos_view AS
            SELECT COUNT(*) AS total_pedidos
            FROM pedidos
        ");
    }

    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS numero_pedidos_view');
    }
};
