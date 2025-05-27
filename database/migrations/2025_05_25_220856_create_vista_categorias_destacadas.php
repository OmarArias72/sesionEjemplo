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
        // Crear vista de categorías más destacadas
        DB::statement("
            CREATE VIEW categorias_mas_destacadas AS
            WITH productos_vendidos_por_categoria AS (
                SELECT 
                    p.id_categoria,
                    p.id_producto,
                    p.nombre_producto,
                    p.descripcion,
                    p.precio,
                    p.stock,
                    p.url_imagen,
                    SUM(dp.cantidad) AS total_vendido,
                    ROW_NUMBER() OVER (PARTITION BY p.id_categoria ORDER BY SUM(dp.cantidad) DESC) AS ranking
                FROM 
                    productos p
                JOIN 
                    detalles_pedidos dp ON p.id_producto = dp.id_producto
                GROUP BY 
                    p.id_categoria, p.id_producto, p.nombre_producto, p.descripcion, p.precio, p.stock, p.url_imagen
            )
            SELECT 
                c.id_categoria,
                c.nombre_categoria,
                c.descripcion,
                SUM(pv.total_vendido) AS total_productos_vendidos,
                pv.id_producto AS producto_destacado_id,
                pv.nombre_producto AS producto_destacado_nombre,
                pv.url_imagen AS producto_destacado_imagen
            FROM 
                categorias c
            JOIN 
                productos_vendidos_por_categoria pv ON c.id_categoria = pv.id_categoria
            WHERE 
                pv.ranking = 1
            GROUP BY 
                c.id_categoria, c.nombre_categoria, c.descripcion,
                pv.id_producto, pv.nombre_producto, pv.url_imagen
            ORDER BY 
                total_productos_vendidos DESC
            LIMIT 5
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS categorias_mas_destacadas');
    }
};
