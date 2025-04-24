<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table="categorias";
    protected $primaryKey = 'id_categoria';
    protected $fillable=[
        "nombre_categoria",
        "descripcion",
        "id_padre"
    ];

    public function productos(){
        return $this->hasMany(Producto::class);
    }
}
