<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    protected $primaryKey = 'pago';
    protected $fillable = [
        'montoPagado',
        'metodoPago',
        'estado',
        'transaccion_id',
        'fechaPago',
        'id_pedido'
    ];

    // Relación con pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }
}
