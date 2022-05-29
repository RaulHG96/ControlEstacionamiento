<?php

use App\Http\Controllers\EstacionamientoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehiculoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'authenticate']);
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('registraEntrada', [EstacionamientoController::class, 'registraEntrada']);
    Route::post('registraSalida', [EstacionamientoController::class, 'registraSalida']);
    Route::post('registraVehiculoOficial', [VehiculoController::class, 'registraVehiculoOficial']);
    Route::post('registraVehiculoResidente', [VehiculoController::class, 'registraVehiculoResidente']);
    Route::post('reiniciaMes', [EstacionamientoController::class, 'reiniciaMes']);
});