<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWasteRibbon extends FormRequest
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
            'largo'  => 'required',
            'fechaInicioTrabajo'   => 'required',
            'fechaFinTrabajo'  => 'required',
            'horaInicioTrabajo'  => 'required',
            'horaFinTrabajo'  => 'required',
            'horaFinTrabajo'  => 'required',
            'observaciones' => 'max:255',
            'empleados.*' => 'distinct'
        ];
    }

    public function messages()
    {
        return [
            'empleados.*.distinct' => 'Empleados duplicados'
        ];
    }
}
