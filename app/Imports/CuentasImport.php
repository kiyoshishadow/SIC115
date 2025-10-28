<?php

namespace App\Imports;

use App\Models\Cuenta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CuentasImport implements ToModel, WithHeadingRow
{
    private int $insertadas = 0;
    private int $duplicadas = 0;

    public function model(array $row)
    {
        
        if (Cuenta::where('codigo', $row['codigo'])->exists()) {
            $this->duplicadas++;
            return null;
        }

        $this->insertadas++;

        return new Cuenta([
            'codigo' => $row['codigo'],
            'nombre' => $row['nombre'],
            'tipo' => $row['tipo'],
            'naturaleza' => $row['naturaleza'],
            'permite_movimientos' => $row['permite_movimientos'],
            'saldo_actual' => $row['saldo_actual'],
        ]);
    }

    public function getInsertadas(): int
    {
        return $this->insertadas;
    }

    public function getDuplicadas(): int
    {
        return $this->duplicadas;
    }
}
