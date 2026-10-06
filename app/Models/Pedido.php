<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente',
        'telefono',
        'total',
        'estado',
    ];

    public function items()
    {
        return $this->hasMany(PedidoItem::class);
    }
}