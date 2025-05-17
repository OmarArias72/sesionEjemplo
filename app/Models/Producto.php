<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table="productos";
    protected $primaryKey = 'id_producto';
    protected $fillable=[
        "nombre_producto",
        "descripcion",
        "estado",
        "url_imagen",
        "url_imagen1",
        "url_imagen2",
        "url_imagen3",
        "stock",
        "precio",
        "id_categoria"
    ];

    public function categorias(){
        return $this->belongsTo(Categoria::class,"id_categoria");
    }
    // Relación con detalles de pedido
    public function detallesPedidos()
    {
        return $this->hasMany(DetallePedido::class, 'id_producto');
    }
}
