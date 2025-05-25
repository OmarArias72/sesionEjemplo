<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaMasDestacada extends Model
{
    protected $table = 'categorias_mas_destacadas';
    public $timestamps = false;
    
    protected $fillable = [
        'id_categoria',
        'nombre_categoria',
        'descripcion',
        'total_productos_vendidos'
    ];
    
    // Relación para obtener el producto más vendido de esta categoría
    public function productoMasVendido()
    {
        return $this->hasOne(Producto::class, 'id_categoria', 'id_categoria')
                   ->orderBy('total_vendido', 'DESC');
    }
}
