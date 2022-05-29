<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class validaVehiculo extends FormRequest
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
            'numPlaca'       => 'required|string|max:10',
        ];
    }

    /**
     * Se costumizan los mensajes de error
     */
    public function messages() {
        return [
            'numPlaca.required'       => 'El número de placa es requerido',
            'numPlaca.string'         => 'El número de placa tiene que ser de tipo cadena de caracteres',
            'numPlaca.max'            => 'El número de placa debe ser de menor de 11 caracteres',
        ];
    }

    /**
     * Se modifica método para que nos retorne el validator del form request y evitar la redirección al código 422
     */
    protected function failedValidation(Validator $validator) {
        $this->validator = $validator;
    }
}
