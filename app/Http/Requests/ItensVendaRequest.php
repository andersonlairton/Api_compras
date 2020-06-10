<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItensVendaRequest extends FormRequest
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
       // var_dump($this->method());
        //die;
        switch ($this->method()) {
            case "POST": {
               
                    return [
                        'quantidade_vendida' => 'required|numeric',
                        'id_produto' => 'required|integer',
                        'id_venda' => 'required|integer',
                    ];
                }
            case "GET":
            case "PUT": {
               // echo 'teste';
                //die;
                    return [
                        'id' => 'required'
                    ];
                }
        }
    }
    public function messages()
    {
        return [
            'required' => ':attributte não pode ser vazio',
            'id_produto.integer' => 'id produto deve ser um inteiro',
            'id_venda.integer' => 'id venda deve ser um inteiro '
        ];
    }
}
