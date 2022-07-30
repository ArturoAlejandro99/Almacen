<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWasteBag extends FormRequest
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
            'peso' => 'required',
            'largo' => 'required',
            'fechaInicioTrabajo' => 'required',
            'horaInicioTrabajo' => 'required',
            'tipoUnidad' => 'required',
            'fechaFinTrabajo' => 'required',
            'horaFinTrabajo' => 'required',
            'cantidad' => 'required',
            'empleados.*' => 'required|distinct'
        ];
    }

    public function messages()
    {
        return [
            'empleados.*.distinct' => 'Empleados duplicados',
            'empleados.*.required' => 'No puede dejar los campos de empleados vacíos'
        ];
    }
}
