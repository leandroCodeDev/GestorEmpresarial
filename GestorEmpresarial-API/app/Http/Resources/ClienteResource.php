<?php

namespace App\Http\Resources;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     *
     * @property Cliente $resource
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->resource->id,
            'nome' => $this->resource->nome,
            'login' => $this->resource->login,
            'cpf' => $this->resource->cpf,
            'email' => $this->resource->email,
            'endereco' => $this->resource->endereco,
            'documento' => asset('storage/'.$this->resource->documento_path),
            'empresas' => new EmpresaCollection($this->whenLoaded('empresas')),
        ];
    }
}
