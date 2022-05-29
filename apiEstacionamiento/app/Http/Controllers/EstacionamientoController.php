<?php

namespace App\Http\Controllers;

use App\Exports\PaymentsExport;
use App\Http\Requests\validaEntradaSalida;
use App\Models\cTipoVehiculo;
use App\Models\cVehiculo;
use App\Models\registroEstacionamiento;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class EstacionamientoController extends Controller
{
    /**
     * Registro de entrada de vehiculos
     * @param  validaEntradaSalida $request [Información de la placa a registrar entrada]
     * @return String                       [String en formato json con la información de registro de entrada]
     */
    public function registraEntrada(validaEntradaSalida $request) {
        $jsonResult = array(
            'success' => true
        );
        try {
            if($request->validator->fails()){
                $jsonResult['success'] = false;
                $jsonResult['error'] = $request->validator->errors();
            } else {
                $horaEntrada = date('Y-m-d H:i:s');
                $existeRegistro = false;
                // Se obtiene el id del vehiculo a partir de la placas enviadas
                $vehiculo = cVehiculo::select('id')
                ->where('numPlaca', '=', $request->get('numPlaca'))
                ->first();
                if(!is_null($vehiculo)) {
                    $vehiculo = $vehiculo->toArray();
                    // Se valida si ya existe registro de hora de entrado de vehiculo
                    $existeRegistro = registroEstacionamiento::where('idcVehiculo', '=', $vehiculo['id'])
                        ->whereNull('horaSalida')
                        ->where('activo', true)
                        ->exists();
                } else {
                    $vehiculo = [];
                }
                if(!$existeRegistro) {
                    if(count($vehiculo) > 0) {
                        $user = null;
                        DB::transaction(function() use($request, $vehiculo, $horaEntrada) {
                            registroEstacionamiento::create([
                                'idcVehiculo' => $vehiculo['id'],
                                'horaEntrada' => $horaEntrada,
                            ]);
                        });
                    } else {
                        // En caso de no estar registrado, significa que es vehiculo de tipo "no residente" y se registra de manera automática como ese tipo
                        $cTipoVehiculo = cTipoVehiculo::select('id')
                            ->where('tipoVehiculo', '=', 'No residente')
                            ->where('habilitado', true)
                            ->where('eliminado', false)
                            ->first()
                            ->toArray();
                        DB::transaction(function() use($request, $cTipoVehiculo, $horaEntrada) {
                            // Se crea vehiculo en catálogo
                            $vehiculo = cVehiculo::create([
                                'numPlaca' => $request->get('numPlaca'),
                                'idcTipoVehiculo' => $cTipoVehiculo['id']
                            ]);
                            // Se registra hora de entrada en registro de estacionamiento
                            registroEstacionamiento::create([
                                'idcVehiculo' => $vehiculo->id,
                                'horaEntrada' => $horaEntrada,
                            ]);
                        });
                    }
                } else {
                    $jsonResult['success'] = false;
                    $jsonResult['error'] = ['Ya existe registro de hora de entrada del vehículo'];
                }
            }
        } catch (Exception $e) {
            $jsonResult['success'] = false;
            $jsonResult['error'] = ['Ocurrió un incidente al registrar entrada de vehículo'];
            // Para pintar excepciones en log de laravel
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Linea: ' . $e->getLine() . '): ' . $e->getMessage());
        }
        return response()->json($jsonResult);
    }
    /**
     * Registro de salida de vehiculos
     * @param  validaEntradaSalida $request [Información de la placa a registrar salida]
     * @return String                       [String en formato json con la información de registro de salida]
     */
    public function registraSalida(validaEntradaSalida $request) {
        $jsonResult = array(
            'success' => true
        );
        try {
            if($request->validator->fails()){
                $jsonResult['success'] = false;
                $jsonResult['error'] = $request->validator->errors();
            } else {
                $horaSalida = date('Y-m-d H:i:s');
                // Se obtiene el id del vehiculo a partir de la placas enviadas
                $vehiculo = cVehiculo::select('id')
                ->where('numPlaca', '=', $request->get('numPlaca'))
                ->first()
                ->toArray();
                // Se valida si ya existe registro de hora de entrado de vehiculo
                $existeRegistro = registroEstacionamiento::where('idcVehiculo', '=', $vehiculo['id'])
                    ->whereNull('horaSalida')
                    ->where('activo', true)
                    ->exists();
                if($existeRegistro) {
                    // Se obtiene la hora de entrada a estacionamiento del vehículo
                    $registroEstacionamiento = registroEstacionamiento::select('horaEntrada')
                        ->whereNull('horaSalida')
                        ->where('idcVehiculo', '=', $vehiculo['id'])
                        ->where('activo', true)
                        ->first()
                        ->toArray();
                    // Se obtiene los minutos que hizo de permanencia en estacionamiento
                    $hora_inicial = strtotime($registroEstacionamiento['horaEntrada']);
                    $hora_final   = strtotime($horaSalida);
                    $minutos      = round(
                        abs($hora_inicial-$hora_final) / 60,
                        2
                    );
                    if(count($vehiculo) > 0) {
                        DB::transaction(function() use($request, $vehiculo, $horaSalida, $minutos) {
                            $isUpdated = registroEstacionamiento::where('idcVehiculo', $vehiculo['id'])
                            ->where('activo', true)
                            ->whereNull('horaSalida')
                            ->update([
                                'horaSalida'   => $horaSalida,
                                'minutosTotal' => $minutos
                            ]);
                            if(!$isUpdated) {
                                throw new Exception('Ocurrió un problema la registrar hora de salida');
                            }
                        });
                        // Se obtiene la cantidad a pagar siempre y cuando el vehículo sea "No residente"
                        
                    } else {
                        $jsonResult['success'] = false;
                        $jsonResult['error'] = ['El vehículo del que intenta registrar salida no se encuentra registrado'];
                    }
                } else {
                    $jsonResult['success'] = false;
                    $jsonResult['error'] = ['No existe la entrada del vehículo del que intenta registrar hora de salida'];
                }
            }
        } catch (Exception | QueryException $e) {
            $jsonResult['success'] = false;
            $jsonResult['error'] = ['Ocurrió un incidente al registrar entrada de vehiculo'];
            // Para pintar excepciones en log de laravel
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Linea: ' . $e->getLine() . '): ' . $e->getMessage());
        }
        return response()->json($jsonResult);
    }
    /**
     * Método para reiniciar mes en estacionamiento
     * @return String [String en formato JSON con la información para el cliente]
     */
    public function reiniciaMes() {
        $jsonResult = array(
            'success' => true
        );
        try {
            $isUpdated = registroEstacionamiento::where('activo', true)
                ->update([
                    'activo' => false
                ]);
            if(!$isUpdated) {
                throw new Exception('Ocurrió un problema al reiniciar mes');
            }
        } catch (Exception $e) {
            $jsonResult['success'] = false;
            $jsonResult['error'] = ['Ocurrió un incidente reiniciar conteo de tiempo de estacionamiento'];
            // Para pintar excepciones en log de laravel
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Linea: ' . $e->getLine() . '): ' . $e->getMessage());
        }
        return response()->json($jsonResult);
    }
    /**
     * Método para generar el archivo de reporte de pagos
     * @return String [String en formato JSON con la información para el cliente]
     */
    public function generaArchivoReporte($nombreArchivo = 'Reporte de pagos') {
        return Excel::download(new PaymentsExport(), $nombreArchivo.'.xlsx', null, [\Maatwebsite\Excel\Excel::XLSX]);
    }
}
