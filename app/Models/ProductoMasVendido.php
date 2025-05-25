<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoMasVendido extends Model
{
    protected $table = 'productos_mas_vendidos';
    public $timestamps = false;
    
    protected $fillable = [
        'id_producto',
        'nombre_producto',
        'descripcion',
        'precio',
        'stock',
        'url_imagen',
        'total_vendido'
    ];
    
    // Relación con el modelo Producto por si se necesita más información
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
