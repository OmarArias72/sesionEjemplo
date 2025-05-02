<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarritoProducto extends Model
{
    protected $table = 'carrito_productos';
    protected $primaryKey = 'id_carrito_producto';
    
    protected $fillable = [
        'id_carrito',
        'id_producto',
        'cantidad',
        'precio_unitario'
    ];

    public function carrito()
    {
        return $this->belongsTo(Carrito::class, 'id_carrito');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
