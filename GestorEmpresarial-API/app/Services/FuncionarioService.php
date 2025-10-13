<?php

namespace App\Services;

use App\Http\Requests\StoreFuncionarioRequest;
use App\Http\Requests\UpdateFuncionarioRequest;
use App\Http\Requests\UploadedDocumentoRequest;
use App\Http\Resources\FuncionarioCollection;
use App\Http\Resources\FuncionarioResource;
use App\Models\Funcionario;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Storage;

class FuncionarioService
{
    public function buscarTodos(): ResourceCollection
    {
        $funcionarios = Funcionario::with('empresas')->get();

        return new FuncionarioCollection($funcionarios);
    }

    public function buscarPorId(int $id): JsonResource
    {
        $funcionario = Funcionario::with('empresas')->find($id);

        return new FuncionarioResource($funcionario);
    }

    public function criar(StoreFuncionarioRequest $request): JsonResource
    {
        $file = $request->file('documento')->store('funcionarios', 'public');
        $funcionario = new Funcionario($request->validated());
        $funcionario->documento_path = $file;
        $funcionario->save();
        $funcionario->empresas()->sync($request->input('empresas'));

        return new FuncionarioResource($funcionario);
    }

    public function atualizar(UpdateFuncionarioRequest $request, int $id): JsonResource
    {
        $funcionario = Funcionario::with('empresas')->find($id);
        $funcionario->update($request->validated());
        if ($request->has('empresas')) {
            // sincroniza as empresas enviadas no request
            $funcionario->empresas()->sync($request->input('empresas'));
        }

        return new FuncionarioResource($funcionario);
    }

    public function excluir(int $id): void
    {
        $funcionario = Funcionario::find($id);
        $funcionario->empresas()->detach();
        Storage::disk('public')->delete($funcionario->documento_path);
        $funcionario->delete();
    }

    public function enviarDocumento(UploadedDocumentoRequest $request, int $id): JsonResource
    {
        $funcionario = Funcionario::find($id);
        Storage::disk('public')->delete($funcionario->documento_path);
        $file = $request->file('documento')->store('funcionarios', 'public');
        $funcionario->documento_path = $file;
        $funcionario->save();

        return new FuncionarioResource($funcionario);
    }
}
