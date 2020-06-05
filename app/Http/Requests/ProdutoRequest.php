<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
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
            'descricao'=>'required|max:255',
            'valor'=>'required|numeric',
            'quantidade_estoque'=>'required|integer'
        ];
    }
    public function messages()
    {
        return[
            'required'=>':attribute não pode ser vazio',
            'valor.numeric'=>'valor tem que ser um numero',
            'quantidade_estoque.integer'=>'quantidade tem que ser um numero inteiro',
            'descricao.max'=>'descricao nao pode ter mais que 255 caracteres'
        ];
    }
}
