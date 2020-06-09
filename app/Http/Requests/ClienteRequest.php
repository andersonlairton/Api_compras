<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
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
            'nome'=>'required|min:3|max:255',
            'cpf_cnpj'=>'required|min:11|max:18'
        ];
    }
    public function messages()
    {
        return [
            'required'=>':atrribute não pode ser vazio',
            'nome.min'=>'nome não deve ser menor que 3 caracteres',
            'nome.max'=>'nome não pode ser maior que 255 caracteres',
            'cpf_cnpj.min'=>'cpf/cnpj não pode ser menor que 11 caracteres',
            'cpf_cnpj.max'=>'cpf/cnpj não pode ser maior que 14 caracteres',
        ];
    }
}
