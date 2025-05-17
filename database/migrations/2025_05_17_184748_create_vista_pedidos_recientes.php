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
            CREATE VIEW pedidos_recientes_view AS
            SELECT 
                p.id_pedido,
                p.estado,
                p.total,
                p.created_at,
                u.nombre || ' ' || u.apellido AS cliente,
                COUNT(dp.id_detalle_pedido) AS productos_count
            FROM 
                pedidos p
            JOIN 
                usuarios u ON p.id_usuario = u.id_usuario
            LEFT JOIN 
                detalles_pedidos dp ON p.id_pedido = dp.id_pedido
            GROUP BY 
                p.id_pedido
            ORDER BY 
                p.created_at DESC
            LIMIT 8
        ");
    }

    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS pedidos_recientes_view');
    }
};
