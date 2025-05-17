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
            CREATE VIEW productos_stock_bajo_view AS
            SELECT 
                id_producto,
                nombre_producto,
                stock,
                precio,
                c.nombre_categoria AS categoria
            FROM 
                productos p
            LEFT JOIN 
                categorias c ON p.id_categoria = c.id_categoria
            WHERE 
                p.estado = 'activo'
            ORDER BY 
                stock ASC
            LIMIT 10
        ");
    }

    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS productos_stock_bajo_view');
    }
};
