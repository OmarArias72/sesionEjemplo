<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $table = 'carritos';
    protected $primaryKey = 'id_carrito';
    
    protected $fillable = [
        'id_usuario',
        'estado'
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'carrito_productos', 'id_carrito', 'id_producto')
                    ->withPivot(['id_carrito_producto', 'cantidad', 'precio_unitario'])
                    ->withTimestamps();
    }

    public function carritoProductos()
    {
        return $this->hasMany(CarritoProducto::class, 'id_carrito');
    }
}
