<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployee extends FormRequest
{
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
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required|max:50',
            'fNacimiento' => 'required',
            'fIngreso' => 'required',
            'antiguedad' => 'required',
            'sueldoHora' => 'required',
            'telefono' => 'required|max:15',
            'status' => 'required'
        ];
    }

    public function attributes()
    {
        return[
            'fNacimiento' => 'fecha de nacimiento',
            'fIngreso' => 'fecha de ingreso',
            'sueldoHora' => 'sueldo por hora',
            'antiguedad' => 'antigüedad',
            'telefono' => 'teléfono',
        ];
    }
}
