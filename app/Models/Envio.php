<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    protected $table = 'envios';
    protected $primaryKey = 'id_envio';
    protected $fillable = [
        'estado',
        'codigoSeguimiento',
        'fechaEnvio',
        'fechaEstimadaEntrega',
        'fechaEntrega',
        'id_pedido',
        'id_empresa'
    ];
    protected $dates = [
        'fechaEnvio',
        'fechaEstimadaEntrega',
        'fechaEntrega',
        'created_at',
        'updated_at'
    ];

    // Estados posibles
    const ESTADO_PENDIENTE = 'Pendiente';
    const ESTADO_ENVIADO = 'Enviado';
    const ESTADO_ENTREGADO = 'Entregado';
    const ESTADO_CANCELADO = 'Cancelado';

    // Relación con pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }

    // Relación con empresa de envío
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }
    
}
