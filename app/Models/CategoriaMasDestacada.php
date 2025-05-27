<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaMasDestacada extends Model
{
    protected $table = 'categorias_mas_destacadas';
    public $timestamps = false;
    
    protected $fillable = [
        'id_categoria',
        'nombre_categoria',
        'descripcion',
        'total_productos_vendidos',
        'producto_destacado_id',
        'producto_destacado_nombre',
        'producto_destacado_imagen'
    ];
    
    // Accesor para obtener la URL de la imagen del producto destacado
    public function getImagenProductoDestacadoAttribute()
    {
        return asset('imagenes/' . $this->producto_destacado_imagen);
    }
}
