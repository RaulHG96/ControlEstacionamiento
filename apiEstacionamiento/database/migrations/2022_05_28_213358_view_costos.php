<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW viewCostos AS
            SELECT
                cVehiculo.numPlaca AS 'NUMERO_PLACA',
                SUM(
                    registroEstacionamiento.minutosTotal
                ) AS 'TIEMPO_ESTACIONADO_MIN',
                (
                    SUM(
                        registroEstacionamiento.minutosTotal
                    ) * cTipoVehiculo.costoEstacionamiento
                ) AS 'TOTAL_PAGAR'
            FROM
                cVehiculo
            INNER JOIN cTipoVehiculo ON cTipoVehiculo.id = cVehiculo.idcTipoVehiculo
            AND cTipoVehiculo.habilitado = TRUE
            AND cTipoVehiculo.eliminado = 0
            INNER JOIN registroEstacionamiento ON registroEstacionamiento.idcVehiculo = cVehiculo.id
            AND registroEstacionamiento.activo = 1
            GROUP BY
                registroEstacionamiento.idcVehiculo
            HAVING TIEMPO_ESTACIONADO_MIN > 0 
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
