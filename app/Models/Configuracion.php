<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $table="configuraciones";
    protected $primaryKey = 'id_configuracion';
    protected $fillable=[
        "correo",
        "nombreTitular",
        "iva"
    ];

    // Método helper para obtener el IVA actual
    public static function getIva()
    {
        $config = self::first();
        return $config ? floatval($config->iva) : 0.16; // 16% por defecto
    }
    
    // Verificar si el IVA está habilitado (diferente de 0)
    public static function isIvaEnabled()
    {
        return self::getIva() > 0;
    }

}
