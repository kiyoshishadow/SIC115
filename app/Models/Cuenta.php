<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cuenta extends Model
{
    use HasFactory;

    protected $fillable = [
        'padre_id',
        'codigo',
        'nombre',
        'tipo',
        'naturaleza',
        'permite_movimientos',
        'saldo_actual',
    ];

    protected $casts = [
        'permite_movimientos' => 'boolean',
        'saldo_actual' => 'decimal:2',
    ];

    // Relación: Una cuenta pertenece a una cuenta padre (opcional)
    public function padre(): BelongsTo
    {
        return $this->belongsTo(Cuenta::class, 'padre_id');
    }

    // Relación: Una cuenta puede tener muchas cuentas hijas
    public function hijos(): HasMany
    {
        return $this->hasMany(Cuenta::class, 'padre_id');
    }

    // Relación: Una cuenta tiene muchos movimientos
    public function movimientos(): HasMany
    {
        return $this->hasMany(Movimiento::class);
    } 
}
