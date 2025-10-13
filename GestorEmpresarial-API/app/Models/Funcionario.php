<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Funcionario extends Model
{
    /** @use HasFactory<\Database\Factories\FuncionarioFactory> */
    use HasFactory;

    protected $fillable = [
        'nome',
        'login',
        'cpf',
        'email',
        'senha',
        'endereco',
        'documento_path',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'senha' => 'hashed',
        ];
    }

    /**
     * @return BelongsToMany<Empresa, Funcionario, EmpresaFuncionario>
     */
    public function empresas(): BelongsToMany
    {
        /** @var BelongsToMany<Empresa, Funcionario, EmpresaFuncionario> */
        return $this->belongsToMany(
            Empresa::class,
            'empresas_funcionarios',
            'funcionario_id',
            'empresa_id'
        )->using(EmpresaFuncionario::class);
    }
}
