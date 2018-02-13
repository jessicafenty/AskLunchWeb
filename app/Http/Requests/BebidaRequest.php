<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BebidaRequest extends FormRequest
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
            'descricao' => 'required|max:150',
            'quantidadeNum' => 'required|max:4',
            'valor' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'descricao.required' => 'Favor informar a DESCRIÇÃO',
            'descricao.max' => 'Favor informar uma DESCRIÇÃO de no máximo 150 caracteres',
            'quantidadeNum.required' => 'Favor informar a QUANTIDADE',
            'quantidadeNum.max' => 'Favor informar uma QUANTIDADE de no máximo 4 caracteres',
            'valor.required' => 'Favor informar o VALOR',
        ];
    }
}
