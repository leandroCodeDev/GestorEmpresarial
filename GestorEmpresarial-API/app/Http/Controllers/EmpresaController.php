<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmpresaRequest;
use App\Http\Requests\UpdateEmpresaRequest;
use App\Services\EmpresaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class EmpresaController extends Controller
{
    public function __construct(
        public EmpresaService $serviceEmpresa
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json($this->serviceEmpresa->buscarTodos());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmpresaRequest $request): JsonResponse
    {
        return response()->json($this->serviceEmpresa->salvar($request), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $empresaId): JsonResponse
    {
        return response()->json($this->serviceEmpresa->buscarPorId($empresaId));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmpresaRequest $request, int $empresaId): JsonResponse
    {
        return response()->json($this->serviceEmpresa->atualizar($request, $empresaId));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $empresaId): Response
    {
        $this->serviceEmpresa->remover($empresaId);

        return response()->noContent();
    }
}
