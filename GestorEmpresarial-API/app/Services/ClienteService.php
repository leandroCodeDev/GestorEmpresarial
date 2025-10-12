<?php

namespace App\Services;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Http\Requests\UploadedDocumentoRequest;
use App\Http\Resources\ClienteCollection;
use App\Http\Resources\ClienteResource;
use App\Models\Cliente;
use Illuminate\Support\Facades\Storage;

class ClienteService {
    public function buscarTodos()
    {

        $clientes = Cliente::with('empresas')->get();
        return new ClienteCollection($clientes);
    }
    public function buscarPorId(int $id)
    {
        $cliente = Cliente::with('empresas')->find($id);
        return new ClienteResource($cliente);
    }
    public function criar(StoreClienteRequest $request)
    {
        $file = $request->file('documento')->store('clientes', 'public');
        $cliente = new Cliente($request->validated());
        $cliente->documento_path =$file;
        $cliente->save();
        $cliente->empresas()->sync($request->input('empresas'));

        return new ClienteResource($cliente);
    }
    public function atualizar(UpdateClienteRequest $request,int $id)
    {
        $cliente = Cliente::with('empresas')->find($id);
        $cliente->update($request->validated());
        if ($request->has('empresas')) {
            $cliente->empresas()->sync($request->input('empresas'));
        }
        return new ClienteResource($cliente);
    }
    public function excluir(int $id)
    {
        $cliente = Cliente::find($id);
        $cliente->empresas()->detach();
        Storage::disk('public')->delete($cliente->documento_path);
        $cliente->delete();
    }
    public function enviarDocumento(UploadedDocumentoRequest $request, int $id)
    {
        $cliente = Cliente::find($id);
        Storage::disk('public')->delete($cliente->documento_path);
        $file = $request->file('documento')->store('clientes', 'public');
        $cliente->documento_path = $file;
        $cliente->save();
        return new ClienteResource($cliente);
    }
}
