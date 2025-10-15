<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFuncionarioRequest extends FormRequest
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
            'nome' => 'nullable|string',
            'login' => 'nullable|string|ascii|unique:funcionarios,login,'.$this->funcionario.',id',
            'cpf' => 'nullable|string|unique:funcionarios,cpf,'.$this->funcionario.',id',
            'email' => 'nullable|email|unique:funcionarios,email,'.$this->funcionario.',id',
            'senha' => 'nullable|string|min:6',
            'endereco' => 'nullable|string',
            'empresas' => 'nullable|array|min:1',
            'empresas.*' => 'integer|exists:empresas,id',
        ];
    }
}
