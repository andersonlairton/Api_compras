<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendaRequest extends FormRequest
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
            'id_cliente'=>'required|integer',
            'valor'=>'required|numeric',
        ];
    }
    public function messages()
    {
        return [
            'required'=>':attribute não pode ser vazio',
            'valor.numeric'=>'valor deve ser um numero ',
            'id_cliente.integer'=>'id cliente deve ser um numero',
        ];
    }
}
