<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'login' => $this->login,
            'cpf' => $this->cpf,
            'email' => $this->email,
            'endereco' => $this->endereco,
            'documento' => asset('storage/'.$this->documento_path),
            'empresas' => new EmpresaCollection($this->whenLoaded('empresas')),
        ];
    }
}
