<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Rol;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'usuarios'; // importante
    protected $primaryKey = 'id_usuario'; // clave primaria personalizada

    public $timestamps = false; // si no usas created_at y updated_at

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'email',
        'password',
        'id_rol',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }
    public function direccion(){
        return $this->hasOne(Direccion::class,"id_usuario");
    }

    // Relación con pedidos
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_usuario');
    }

    // Relación con carrito (uno a uno)
    public function carrito()
    {
        return $this->hasOne(Carrito::class, 'id_usuario');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function getAuthIdentifierName()
    {
        return 'id_usuario';
    }
    public function getAuthIdentifier()
    {
        return $this->getKey(); // Esto devuelve el id_usuario
    }

    // Obtener el carrito activo del usuario
    public function carritoActivoProductosCount()
    {
        // Obtener el carrito activo del usuario
        $carrito = $this->carrito()
                        ->where('estado', 'activo')
                        ->first();
        
        // Si no hay carrito activo, retornar 0
        if (!$carrito) {
            return 0;
        }
        
        // Retornar la suma de las cantidades de todos los productos en el carrito
        return $carrito->carritoProductos()->sum('cantidad');
    }
}
