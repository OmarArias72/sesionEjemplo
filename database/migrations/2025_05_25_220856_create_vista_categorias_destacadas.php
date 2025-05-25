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
            SELECT 
                c.id_categoria,
                c.nombre_categoria,
                c.descripcion,
                SUM(dp.cantidad) AS total_productos_vendidos
            FROM 
                categorias c
            JOIN 
                productos p ON c.id_categoria = p.id_categoria
            JOIN 
                detalles_pedidos dp ON p.id_producto = dp.id_producto
            GROUP BY 
                c.id_categoria, c.nombre_categoria, c.descripcion
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
