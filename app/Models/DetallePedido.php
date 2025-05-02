<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    protected $table = 'detalles_pedidos';
    protected $primaryKey = 'id_detalle_pedido';
    protected $fillable = [
        'cantidad',
        'precioUnitario',
        'id_pedido',
        'id_producto'
    ];

    // Relación con pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }

    // Relación con producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
