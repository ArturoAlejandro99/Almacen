<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoilType extends FormRequest
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
        if($this->has('coilTypeForm'))
        {
            return [
                'alias' => 'required',
                'anchoCm' => 'required',
                'largoM' => 'required',
                'densidad' => 'required',
                'material' => 'required',
                'calibre' => 'required',
                'tipo' => 'required',
                'observaciones' => 'max:255'
            ];
        }
        
        //REQUEST PARA MEDIDAS DE BOLSA
        return [
            'ancho' => 'required',
            'largo' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'anchoCm' => 'ancho(cm)',
            'largoM' => 'largo(m)'
        ];
    }
}
