<?php

namespace App\Services;

use App\Http\Requests\StoreEmpresaRequest;
use App\Http\Requests\UpdateEmpresaRequest;
use App\Http\Resources\EmpresaCollection;
use App\Http\Resources\EmpresaResource;
use App\Models\Empresa;


class EmpresaService {

    public function buscarTodos()
    {
        $empresas = Empresa::all();
        return new EmpresaCollection($empresas);
    }

    public function buscarPorId(int $id){
        $empresa = Empresa::find($id);
        return new EmpresaResource($empresa);
    }

    public function atualizar(UpdateEmpresaRequest $request, int $id)
    {
        $empresa = Empresa::find($id);
        $empresa->update($request->validated());
        return new EmpresaResource($empresa);
    }


    public function salvar(StoreEmpresaRequest $request)
    {

        $empresa = new Empresa($request->validated());
        $empresa->save();
        return new EmpresaResource($empresa);
    }

    public function remover(int $id)
    {
        Empresa::destroy($id);
    }
}
