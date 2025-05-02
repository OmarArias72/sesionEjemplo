<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table="empresas_envio";
    protected $primaryKey = 'id_empresa';
    protected $fillable=[
        "nombreEmpresa",
        "nombreContacto",
        "numeroContacto",
        "correo"
    ];

    // Relación con envíos
    public function envios()
    {
        return $this->hasMany(Envio::class, 'id_empresa');
    }
}
