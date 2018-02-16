<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormaPagamentoRequest extends FormRequest
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
            'formapagamento' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'formapagamento.required' => 'Favor informar um valor para o campo DESCRIÇÃO',
        ];
    }
}