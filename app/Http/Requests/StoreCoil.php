<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoil extends FormRequest
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
            'status' => 'required',
            'fArribo' => 'required',
            'pesoBruto' => 'required',
            'largoM' => 'required',
            'costo' => 'required',
            'provider_id' => 'required',
            'coil_type_id' => 'required',
            'observaciones' => 'max:255'
        ];
    }

    public function attributes()
    {
        return [
            'coil_type_id' => 'tipo bobina',
            'provider_id' => 'proveedor',
            'fArribo' => 'fecha llegada',
            'largoM' => 'largo(metros)'
        ];
    }
}
