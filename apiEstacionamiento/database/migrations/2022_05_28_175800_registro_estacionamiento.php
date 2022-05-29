<?php

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
        Schema::create('registroEstacionamiento', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->mediumIncrements('id');
            $table->unsignedSmallInteger('idcVehiculo');
            $table->dateTime('horaEntrada');
            $table->dateTime('horaSalida')->nullable();
            $table->float('minutosTotal', 5, 2)->default(0);
            $table->boolean('activo')->default(true);
            $table->foreign('idcVehiculo')->references('id')->on('cVehiculo');
            $table->timestamps();
        });
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
