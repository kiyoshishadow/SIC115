<?php

namespace App\Imports;

use App\Models\Cuenta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CuentasImport implements ToModel, WithHeadingRow
{
    use Importable;

    private $rowCount = 0;

    public function model(array $row)
    {
        $this->rowCount++;

        return new Cuenta([
            'codigo' => $row['codigo'],
            'nombre' => $row['nombre'],
            'tipo' => $row['tipo'],
            'naturaleza' => $row['naturaleza'],
            'permite_movimientos' => $row['permite_movimientos'],
            'saldo_actual' => $row['saldo_actual'],
        ]);
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }
}
