<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\FuncionarioController;
use Illuminate\Support\Facades\Route;

Route::apiResource('empresas', EmpresaController::class);

Route::apiResource('clientes', ClienteController::class);
Route::post('clientes/{id}/documento', [ClienteController::class, 'enviarDocumento']);

Route::apiResource('funcionarios', controller: FuncionarioController::class);
Route::post('funcionarios/{id}/documento', [FuncionarioController::class, 'enviarDocumento']);

// Route::get('/user', function (Request $request) {
//    return $request->user();
// })->middleware('auth:sanctum');
