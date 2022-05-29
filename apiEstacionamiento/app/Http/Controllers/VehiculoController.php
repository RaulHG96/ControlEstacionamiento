<?php

namespace App\Http\Controllers;

use App\Http\Requests\validaVehiculo;
use App\Models\cTipoVehiculo;
use App\Models\cVehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VehiculoController extends Controller
{
    /**
     * Método que registra a los vehiculos oficiales
     * @param  validaVehiculo $request [Información con el número de placas del vehículo]
     * @return String                  [String en formato JSON con la información para el cliente]
     */
    public function registraVehiculoOficial(validaVehiculo $request) {
        $jsonResult = array(
            'success' => true
        );
        try {
            if($request->validator->fails()){
                $jsonResult['success'] = false;
                $jsonResult['error'] = $request->validator->errors();
            } else {
                $cTipoVehiculo = cTipoVehiculo::select('id')
                    ->where('tipoVehiculo', '=', 'Oficial')
                    ->where('habilitado', true)
                    ->where('eliminado', false)
                    ->first()
                    ->toArray();
                // Se valida si vehiculo ya se encuentra registrado
                $existeVehiculo = cVehiculo::where('numPlaca', '=', $request->get('numPlaca'))
                    ->where('idcTipoVehiculo', '=', $cTipoVehiculo['id'])
                    ->exists();
                if(!$existeVehiculo) {
                    DB::transaction(function() use($request, $cTipoVehiculo) {
                        cVehiculo::create([
                            'numPlaca' => $request->get('numPlaca'),
                            'idcTipoVehiculo' => $cTipoVehiculo['id']
                        ]);
                    });
                } else {
                    $jsonResult['success'] = false;
                    $jsonResult['error'] = ['El vehículo que intenta registrar ya se encuentra registrado como vehículo oficial'];
                }
            }
        } catch (Exception $e) {
            $jsonResult['success'] = false;
            $jsonResult['error'] = ['Ocurrió un incidente al registrar vehículo oficial'];
            // Para pintar excepciones en log de laravel
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Linea: ' . $e->getLine() . '): ' . $e->getMessage());
        }
        return response()->json($jsonResult);
    }
    /**
     * Método que registra a los vehiculos residentes
     * @param  validaVehiculo $request [Información con el número de placas del vehículo]
     * @return String                  [String en formato JSON con la información para el cliente]
     */
    public function registraVehiculoResidente(validaVehiculo $request) {
        $jsonResult = array(
            'success' => true
        );
        try {
            if($request->validator->fails()){
                $jsonResult['success'] = false;
                $jsonResult['error'] = $request->validator->errors();
            } else {
                $cTipoVehiculo = cTipoVehiculo::select('id')
                    ->where('tipoVehiculo', '=', 'Residente')
                    ->where('habilitado', true)
                    ->where('eliminado', false)
                    ->first()
                    ->toArray();
                // Se valida si vehiculo ya se encuentra registrado
                $existeVehiculo = cVehiculo::where('numPlaca', '=', $request->get('numPlaca'))
                    ->where('idcTipoVehiculo', '=', $cTipoVehiculo['id'])
                    ->exists();
                if(!$existeVehiculo) {
                    DB::transaction(function() use($request, $cTipoVehiculo) {
                        cVehiculo::create([
                            'numPlaca' => $request->get('numPlaca'),
                            'idcTipoVehiculo' => $cTipoVehiculo['id']
                        ]);
                    });
                } else {
                    $jsonResult['success'] = false;
                    $jsonResult['error'] = ['El vehículo que intenta registrar ya se encuentra registrado como vehículo residente'];
                }
            }
        } catch (Exception $e) {
            $jsonResult['success'] = false;
            $jsonResult['error'] = ['Ocurrió un incidente al registrar vehículo residente'];
            // Para pintar excepciones en log de laravel
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Linea: ' . $e->getLine() . '): ' . $e->getMessage());
        }
        return response()->json($jsonResult);
    }
}
