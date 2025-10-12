<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empresa_funcionario', function (Blueprint $table) {
            $table->foreignId('funcionario_id')->constrained('funcionarios');
            $table->foreignId('empresa_id')->constrained('empresas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa_funcionario');
    }
};
