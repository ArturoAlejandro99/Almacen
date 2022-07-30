<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRibbon extends FormRequest
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
            'nomenclatura' => 'required',
            'peso' => 'required',
            'largo' => 'required',
            'fechaInicioTrabajo' => 'required',
            'fechaFinTrabajo' => 'required',
            'horaInicioTrabajo' => 'required',
            'horaFinTrabajo' => 'required',
            'status' => 'required',
            'pesoUtilizado' => 'required',
            'observaciones' => 'max:255',
            'empleados.*' => 'required|distinct',
            'white_ribbon_ids.*' => 'distinct',
            'largos.*' => 'required'
        ];
    }
    
    public function messages()
    {
        return [
            'empleados.*.distinct' => 'Empleados duplicados',
            'empleados.*.required' => 'No puede dejar los campos de empleados vacíos',
            'white_ribbon_ids.*.distinct' => 'Cintillas blancas duplicadas',
            'white_ribbon_ids.*.required' => 'No puede dejar los campos de cintillas blancas vacías',
            'largos.*.required' => 'No puede dejar los campos de largo(metros) vacíos'
        ];
    }
}
