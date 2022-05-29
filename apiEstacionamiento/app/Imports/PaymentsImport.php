<?php

namespace App\Imports;

use App\Models\viewCostos;
use Maatwebsite\Excel\Concerns\ToModel;

class PaymentsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new viewCostos([
            'NUMERO_PLACA'           => $row['NUMERO_PLACA'],
            'TIEMPO_ESTACIONADO_MIN' => $row['TIEMPO_ESTACIONADO_MIN'],
            'TOTAL_PAGAR'            => $row['TOTAL_PAGAR']
        ]);
    }
}
