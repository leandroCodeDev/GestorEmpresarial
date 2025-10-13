<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Http\Requests\UploadedDocumentoRequest;
use App\Services\ClienteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ClienteController extends Controller
{
    public function __construct(
        public ClienteService $clienteService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json($this->clienteService->buscarTodos(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClienteRequest $request): JsonResponse
    {
        return response()->json($this->clienteService->criar($request), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $clienteId): JsonResponse
    {
        return response()->json($this->clienteService->buscarPorId($clienteId), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClienteRequest $request, int $clienteId): JsonResponse
    {
        return response()->json($this->clienteService->atualizar($request, $clienteId), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $clienteId): Response
    {
        $this->clienteService->excluir($clienteId);

        return response()->noContent();
    }

    public function enviarDocumento(UploadedDocumentoRequest $request, int $clienteId): JsonResponse
    {
        return response()->json($this->clienteService->enviarDocumento($request, $clienteId), 201);
    }
}
