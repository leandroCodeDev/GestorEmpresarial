<?php

namespace App\Services;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Http\Requests\UploadedDocumentoRequest;
use App\Http\Resources\ClienteCollection;
use App\Http\Resources\ClienteResource;
use App\Models\Cliente;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Storage;

class ClienteService
{
    public function buscarTodos(): ResourceCollection
    {

        $clientes = Cliente::with('empresas')->get();

        return new ClienteCollection($clientes);
    }

    public function buscarPorId(int $id): JsonResource
    {
        $cliente = Cliente::with('empresas')->find($id);

        return new ClienteResource($cliente);
    }

    public function criar(StoreClienteRequest $request): JsonResource
    {
        $file = $request->file('documento')->store('clientes', 'public');
        $cliente = new Cliente($request->validated());
        $cliente->documento_path = $file;
        $cliente->save();
        $cliente->empresas()->sync($request->input('empresas'));

        return new ClienteResource($cliente);
    }

    public function atualizar(UpdateClienteRequest $request, int $id): JsonResource
    {
        $cliente = Cliente::with('empresas')->find($id);
        $cliente->update($request->validated());
        if ($request->has('empresas')) {
            $cliente->empresas()->sync($request->input('empresas'));
        }

        return new ClienteResource($cliente);
    }

    public function excluir(int $id): void
    {
        $cliente = Cliente::find($id);
        $cliente->empresas()->detach();
        Storage::disk('public')->delete($cliente->documento_path);
        $cliente->delete();
    }

    public function enviarDocumento(UploadedDocumentoRequest $request, int $id): JsonResource
    {
        $cliente = Cliente::find($id);
        Storage::disk('public')->delete($cliente->documento_path);
        $file = $request->file('documento')->store('clientes', 'public');
        $cliente->documento_path = $file;
        $cliente->save();

        return new ClienteResource($cliente);
    }
}
