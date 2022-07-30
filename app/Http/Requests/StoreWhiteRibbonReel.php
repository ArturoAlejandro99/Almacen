<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWhiteRibbonReel extends FormRequest
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
                'status' => 'required',
                'observaciones' => 'max:255',
                'fechaAlta' => 'required',
                'whiteRibbonId' => 'required'
        ];
    }
}
