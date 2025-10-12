<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string',
            'login' => 'required|alpha_dash:ascii|unique:clientes,login,'.$this->cliente.',id',
            'cpf' => 'required|string|unique:clientes,cpf,'.$this->cliente.',id',
            'email' => 'required|email|unique:clientes,email,'.$this->cliente.',id',
            'senha' => 'required|string|min:6',
            'endereco' => 'required|string',
            'empresas' => 'required|array|min:1',
            'empresas.*' => 'integer|exists:empresas,id',
        ];
    }
}
