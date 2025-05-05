<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $primaryKey = 'id_pedido';
    protected $table="pedidos";
    public $timestamps=true;
    // Relación con usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    // Relación con dirección
    public function direccion()
    {
        return $this->belongsTo(Direccion::class, 'id_direccion');
    }

    // Relación con detalles de pedido
    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'id_pedido');
    }

    // Relación con pago
    public function pago()
    {
        return $this->hasOne(Pago::class, 'id_pedido');
    }

    // Relación con envío
    public function envio()
    {
        return $this->hasOne(Envio::class, 'id_pedido');
    }
    // Método para verificar si ya tiene envío
    public function tieneEnvio()
    {
        return $this->envio()->exists();
    }
}
