<?php

namespace App\Http\Controllers;

use App\Http\Requests\registerUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Exception;

class UserController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'error'   => ['Las credenciales proporcionadas no son correctas']
                ], 400);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'error' => ['El token de acceso no pudo ser creado']
            ], 500);
        }
        return response()->json(compact('token'));
    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                    return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
             return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(compact('user'));
    }

    /**
     * Registro de nuevos usuarios para el uso de la api
     * @param  registerUser $request [Datos para registro]
     * @return String                [String en formato JSON con respuesta para el cliente]
     */
    public function register(registerUser $request)
    {
        $jsonResult = array(
            'success' => true
        );
        try {
            if($request->validator->fails()){
                $jsonResult['success'] = false;
                $jsonResult['error'] = $request->validator->errors();
            } else {
                $user = null;
                DB::transaction(function() use(&$user, $request) {
                    $user = User::create([
                        'name' => $request->get('name'),
                        'email' => $request->get('email'),
                        'password' => Hash::make($request->get('password')),
                    ]);
                });

                $token = JWTAuth::fromUser($user);
            }
        } catch (Exception $e) {
            $jsonResult['success'] = false;
            $jsonResult['error'] = ['Ocurrió un incidente al almacenar la información'];
            // Para pintar excepciones en log de laravel
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Linea: ' . $e->getLine() . '): ' . $e->getMessage());
        }
        return response()->json($jsonResult);
    }
}
