<?php

namespace App\Http\Resources;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmpresaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     *
     * @property Empresa $resource
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'nome' => $this->resource->nome,
            'cnpj' => $this->resource->cnpj,
            'endereco' => $this->resource->endereco,
            'clientes' => new ClienteCollection($this->whenLoaded('clientes')),
            'funcionarios' => new FuncionarioCollection($this->whenLoaded('funcionarios')),
        ];
    }
}
