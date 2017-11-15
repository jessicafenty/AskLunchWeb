<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FuncionarioRequest extends FormRequest
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
            'nome' => 'required|max:150',
            'telefone' => 'required',
            'data_nascimento' => 'required',
            'logradouro' => 'required|max:150',
            'bairro' => 'required|max:100',
            'email' => 'required|max:150|email',
            'senha' => 'required|max:100',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'Favor informar o NOME',
            'telefone.required' => 'Favor informar o TELEFONE',
            'data_nascimento.required' => 'Favor informar a DATA DE NASCIMENTO',
            'logradouro.required' => 'Favor informar o LOGRADOURO',
            'bairro.required' => 'Favor informar o BAIRRO',
            'email.required' => 'Favor informar o EMAIL',
            'senha.required' => 'Favor informar a SENHA',
        ];
    }
}
