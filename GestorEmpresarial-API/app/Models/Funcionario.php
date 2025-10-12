<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

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
     * @return HasOneThrough
     */
    public function empresas(): BelongsToMany
    {
        return $this->BelongsToMany(Empresa::class,'empresas_funcionarios');
    }
}
