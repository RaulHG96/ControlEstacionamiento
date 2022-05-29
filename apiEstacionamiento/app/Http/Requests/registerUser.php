<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class registerUser extends FormRequest
{
    public $validator = null;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ];
    }

    /**
     * Se costumizan los mensajes de error
     */
    public function messages() {
        return [
            'name.required'     => 'El nombre es requerido',
            'name.string'       => 'El nombre tiene que ser de tipo cadena de caracteres',
            'name.mas'          => 'El nombre debe ser de menos de 256 caracteres',
            'email'             => 'El correo electrónico es requerido',
            'email.string'      => 'El correo electrónico debe ser de tipo cadena de caracteres',
            'email.max'         => 'El correo electrónico debe ser de menos de 256 caracteres',
            'email.unique'      => 'El correo electrónico ya existe registrado en sistema',
            'password.required' => 'La contraseña es requerida',
            'password.string'   => 'La contraseña debe ser de tipo cadena de caracteres',
            'password.min'      => 'La contraseña debe ser de la menos de caracteres'
        ];
    }

    /**
     * Se modifica método para que nos retorne el validator del form request y evitar la redirección al código 422
     */
    protected function failedValidation(Validator $validator) {
        $this->validator = $validator;
    }
}
