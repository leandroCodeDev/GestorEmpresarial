<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFuncionarioRequest;
use App\Http\Requests\UpdateFuncionarioRequest;
use App\Http\Requests\UploadedDocumentoRequest;
use App\Models\Funcionario;
use App\Services\FuncionarioService;

class FuncionarioController extends Controller
{

    public function __construct(
        public FuncionarioService $funcionarioService
    )
    {
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->funcionarioService->buscarTodos(), 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFuncionarioRequest $request)
    {
        return response()->json($this->funcionarioService->criar($request), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $clienteId)
    {
        return response()->json($this->funcionarioService->buscarPorId($clienteId), 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFuncionarioRequest $request, int $clienteId)
    {
        return response()->json($this->funcionarioService->atualizar($request,$clienteId), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $clienteId)
    {
        $this->funcionarioService->excluir($clienteId);
        return response()->noContent();
    }


    public function enviarDocumento(UploadedDocumentoRequest $request, int $clienteId)
    {
        return response()->json($this->funcionarioService->enviarDocumento($request,$clienteId),201);
    }
}
