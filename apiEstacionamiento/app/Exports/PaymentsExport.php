<?php

namespace App\Exports;

use App\Models\viewCostos;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return viewCostos::select('NUMERO_PLACA', 'TIEMPO_ESTACIONADO_MIN', 'TOTAL_PAGAR')->get();
    }
    /**
     * Método para las cabeceras del excel
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["Núm. placa", "Tiempo estacionado (min.)", "Cantidad a pagar"];
    }
}
