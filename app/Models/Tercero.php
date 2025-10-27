<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tercero extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nombre',
        'nrc',
        'nit',
        'giro',
        'es_cliente',
        'es_proveedor',
        'es_gran_contribuyente',
    ];

    protected $casts = [
        'es_cliente' => 'boolean',
        'es_proveedor' => 'boolean',
        'es_gran_contribuyente' => 'boolean',
    ];

    // Relación: Un tercero (cliente/proveedor) puede estar en muchos registros de IVA
    public function librosIva(): HasMany
    {
        return $this->hasMany(LibroIva::class);
    }
}
