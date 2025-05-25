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
    public function up(): void
    {
        // Crear vista de productos más vendidos
        DB::statement("
            CREATE VIEW productos_mas_vendidos AS
            SELECT 
                p.id_producto,
                p.nombre_producto,
                p.descripcion,
                p.precio,
                p.stock,
                p.url_imagen,
                SUM(dp.cantidad) AS total_vendido
            FROM 
                productos p
            JOIN 
                detalles_pedidos dp ON p.id_producto = dp.id_producto
            GROUP BY 
                p.id_producto, p.nombre_producto, p.descripcion, p.precio, p.url_imagen
            ORDER BY 
                total_vendido DESC
            LIMIT 5
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS productos_mas_vendidos');
    }
};
