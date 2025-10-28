<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibroIva extends Model
{
    use HasFactory;

    protected $table = 'libros_iva';

    protected $fillable = [
        'asiento_id',
        'tercero_id',
        'tipo_libro',
        'fecha_documento',
        'tipo_documento',
        'numero_documento',
        'monto_neto',
        'monto_exento',
        'iva_credito_fiscal',
        'iva_debito_fiscal',
        'iva_percibido',
        'iva_retenido',
        'total_documento',
        'concepto',
    ];

    protected $casts = [
        'monto_neto' => 'decimal:2',
        'monto_exento' => 'decimal:2',
        'iva_credito_fiscal' => 'decimal:2',
        'iva_debito_fiscal' => 'decimal:2',
        'iva_percibido' => 'decimal:2',
        'iva_retenido' => 'decimal:2',
        'total_documento' => 'decimal:2',
    ];

    // Relación: Un registro de IVA pertenece a un asiento contable
    public function asiento(): BelongsTo
    {
        return $this->belongsTo(Asiento::class);
    }

    // Relación: Un registro de IVA pertenece a un tercero
    public function tercero(): BelongsTo
    {
        return $this->belongsTo(Tercero::class);
    }
}
