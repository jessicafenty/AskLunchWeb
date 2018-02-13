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
            'quadra' => 'max:4',
            'lote' => 'max:4',
            'email' => 'required|max:150|email',
            'senha' => 'required|min:6|max:8',
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
            'senha.min' => 'Favor informar uma SENHA de no mínimo 6 caracteres',
            'senha.max' => 'Favor informar uma SENHA de no máximo 8 caracteres',
            'nome.max' => 'Favor informar um NOME de no máximo 150 caracteres',
            'email.max' => 'Favor informar um EMAIL de no máximo 150 caracteres',
            'email.email' => 'Favor informar um EMAIL válido',
            'logradouro.max' => 'Favor informar um LOGRADOURO de no máximo 150 caracteres',
            'bairro.max' => 'Favor informar um BAIRRO de no máximo 100 caracteres',
            'quadra.max' => 'Favor informar uma QUADRA de no máximo 4 caracteres',
            'lote.max' => 'Favor informar um LOTE de no máximo 4 caracteres',
            'email.unique' => 'Email já existente, favor informar outro EMAIL',
        ];
    }
}
