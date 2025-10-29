<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asiento extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'fecha',
        'numero_asiento',
        'total_debe',
        'total_haber',
        'descripcion',
        'tipo_asiento',
    ];
    
    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }
}
