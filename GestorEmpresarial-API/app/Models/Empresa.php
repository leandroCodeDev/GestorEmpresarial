<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empresa extends Model
{
    /** @use HasFactory<\Database\Factories\EmpresaFactory> */
    use HasFactory;

    protected $fillable = [
        'nome',
        'cnpj',
        'endereco',
    ];

    public function funcionarios(): BelongsToMany
    {
        return $this->BelongsToMany(Funcionario::class,'empresas_funcionarios');
    }

    public function clientes():BelongsToMany
    {
        return $this->BelongsToMany(Cliente::class,'empresas_clientes');
    }
}
