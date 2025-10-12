<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmpresaRequest;
use App\Http\Requests\UpdateEmpresaRequest;
use App\Models\Empresa;
use App\Services\EmpresaService;

class EmpresaController extends Controller
{
    public function __construct(
        public EmpresaService $serviceEmpresa
    )
    {
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->serviceEmpresa->buscarTodos();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmpresaRequest $request)
    {
        return $this->serviceEmpresa->salvar($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $empresaId)
    {
        return $this->serviceEmpresa->buscarPorId($empresaId);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmpresaRequest $request, int $empresaId)
    {
        return $this->serviceEmpresa->atualizar($request, $empresaId);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $empresaId)
    {
         $this->serviceEmpresa->remover($empresaId);
    }
}
