<?php

use App\Http\Controllers\EmpresaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('empresas', EmpresaController::class);



//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
