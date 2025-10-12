<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
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
            'login' => 'required|alpha_dash:ascii|unique:clientes,login',
            'cpf' => 'required|string|unique:clientes,cpf',
            'email' => 'required|email|unique:clientes,email',
            'senha' => 'required|string|min:6',
            'endereco' => 'required|string',
            'documento' => 'required|file|mimes:pdf,jpg|max:20048',
            'empresas' => 'required|array|min:1',
            'empresas.*' => 'integer|exists:empresas,id',
        ];
    }
}
