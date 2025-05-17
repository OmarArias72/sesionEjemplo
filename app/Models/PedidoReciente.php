<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoReciente extends Model
{
    protected $table = 'pedidos_recientes_view';

     // Campos accesibles
    protected $appends = ['formatted_total', 'formatted_date'];
    
    // Formatear el total como moneda
    public function getFormattedTotalAttribute()
    {
        return '$' . number_format($this->total, 2);
    }
    
    // Formatear la fecha
    public function getFormattedDateAttribute()
    {
        return \Carbon\Carbon::parse($this->created_at)->format('d M Y');
    }
}
