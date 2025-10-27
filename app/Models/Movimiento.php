<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'asiento_id',
        'cuenta_id',
        'descripcion',
        'debe',
        'haber',
    ];

    protected $casts = [
        'debe' => 'decimal:2',
        'haber' => 'decimal:2',
    ];

    // Relación: Un movimiento pertenece a un asiento
    public function asiento(): BelongsTo
    {
        return $this->belongsTo(Asiento::class);
    }

    // Relación: Un movimiento pertenece a una cuenta
    public function cuenta(): BelongsTo
    {
        return $this->belongsTo(Cuenta::class);
    }
}
