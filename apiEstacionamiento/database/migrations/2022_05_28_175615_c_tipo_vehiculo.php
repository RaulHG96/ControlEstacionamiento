<?php

use App\Models\cTipoVehiculo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('cTipoVehiculo', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->smallIncrements('id');
            $table->string('tipoVehiculo',30)->default('');
            $table->float('costoEstacionamiento', 3, 2)->default(0);
            $table->boolean('habilitado')->default(true);
            $table->boolean('eliminado')->default(false);
            $table->timestamps();
        });

        cTipoVehiculo::create([
            'tipoVehiculo' => 'Oficial',
            'costoEstacionamiento' => 0
        ]);

        cTipoVehiculo::create([
            'tipoVehiculo' => 'Residente',
            'costoEstacionamiento' => 0.05
        ]);

        cTipoVehiculo::create([
            'tipoVehiculo' => 'No residente',
            'costoEstacionamiento' => 0.5
        ]);
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
