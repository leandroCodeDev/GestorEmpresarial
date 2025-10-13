<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Empresa extends Model
{
    /** @use HasFactory<\Database\Factories\EmpresaFactory> */
    use HasFactory;

    protected $fillable = [
        'nome',
        'cnpj',
        'endereco',
    ];

    /**
     * @return BelongsToMany< Funcionario,Empresa, EmpresaFuncionario>
     */
    public function funcionarios(): BelongsToMany
    {
        /** @var BelongsToMany<Funcionario,Empresa, EmpresaFuncionario> */
        return $this->BelongsToMany(
            Funcionario::class,
            'empresas_funcionarios',
            'empresa_id',
            'funcionario_id'
        )->using(EmpresaFuncionario::class);
    }

    /**
     * @return BelongsToMany< Cliente,Empresa, EmpresaCliente>
     */
    public function clientes(): BelongsToMany
    {
        /** @var BelongsToMany< Cliente,Empresa, EmpresaCliente> */
        return $this->BelongsToMany(
            Cliente::class,
            'empresas_clientes',
            'empresa_id',
            'cliente_id'
        )->using(EmpresaCliente::class);
    }
}
