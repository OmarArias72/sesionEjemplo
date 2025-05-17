<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoStockBajo extends Model
{
    protected $table = 'productos_stock_bajo_view';

     // Campos accesibles
    protected $appends = ['formatted_price', 'stock_status'];
    
    // Formatear el precio
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->precio, 2);
    }
    
    // Determinar el estado del stock
    public function getStockStatusAttribute()
    {
        if ($this->stock <= 3) return 'low';
        if ($this->stock <= 10) return 'medium';
        return 'high';
    }
}
