<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $table="direcciones";
    protected $primaryKey = 'id_direccion';
    protected $fillable=[
        "calle",
        "colonia",
        "ciudad",
        "estado",
        "pais",
        "codigoPostal",
        "numeroExterior",
        "id_usuario"

    ];

    public function usuario(){
        return $this->belongsTo(User::class,"id_usuario");
    }
    // Relación con pedidos
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_direccion');
    }
}
