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
        'descripcion',
        'tipo_asiento',
    ];
    /*
    public function libroIvas()
    {
        return $this->hasMany(Movimiento::class);
    }*/
}
