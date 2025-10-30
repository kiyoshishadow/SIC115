<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

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

    protected static function booted(): void
    {
        static::created(function (Movimiento $movimiento) {
            // Usamos una transacción por si algo falla
            DB::transaction(function () use ($movimiento) {
                $cuenta = Cuenta::lockForUpdate()->find($movimiento->cuenta_id);
                if (!$cuenta) return; // Si la cuenta no existe, no hacemos nada
                $montoDelta = 0;
                // 2. Aplicamos la lógica contable
                if ($cuenta->naturaleza === 'Deudor') {
                    $montoDelta = $movimiento->debe - $movimiento->haber;
                } else if ($cuenta->naturaleza === 'Acreedor') {
                    $montoDelta = $movimiento->haber - $movimiento->debe;
                }

                // 3. Guardamos el nuevo saldo en la cuenta
                $cuenta->actualizarSaldoRecursivo($montoDelta);
            });
        });

        static::updated(function (Movimiento $movimiento) {
            // Este es más complejo: debemos revertir el cambio viejo Y aplicar el nuevo
            DB::transaction(function () use ($movimiento) {
                $cuenta = Cuenta::lockForUpdate()->find($movimiento->cuenta_id);
                if (!$cuenta) return;

                // 1. Obtenemos los valores VIEJOS (antes de la edición)
                $viejoDebe = $movimiento->getOriginal('debe');
                $viejoHaber = $movimiento->getOriginal('haber');
                $montoDelta = 0;
                if ($cuenta->naturaleza === 'Deudor') {
                    $montoDelta = ($movimiento->debe - $movimiento->haber) - ($viejoDebe - $viejoHaber);
                } else if ($cuenta->naturaleza === 'Acreedor') {
                    $montoDelta = ($movimiento->haber - $movimiento->debe) - ($viejoHaber - $viejoDebe);
                }

                $cuenta->actualizarSaldoRecursivo($montoDelta);
            });
        });

        
        static::deleted(function (Movimiento $movimiento) {
            DB::transaction(function () use ($movimiento) {
                $cuenta = Cuenta::lockForUpdate()->find($movimiento->cuenta_id);
                if (!$cuenta) return;

                $montoDelta = 0;
                // 1. REVERTIMOS el movimiento que se acaba de borrar
                if ($cuenta->naturaleza === 'Deudor') {
                    $montoDelta = $movimiento->haber - $movimiento->debe;
                } else if ($cuenta->naturaleza === 'Acreedor') {
                    
                    $montoDelta = $movimiento->debe - $movimiento->haber;
                }

                // 2. Guardamos el saldo
                $cuenta->actualizarSaldoRecursivo($montoDelta);
            });
        });
    }
}
