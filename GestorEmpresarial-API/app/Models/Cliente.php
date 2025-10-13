<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cliente extends Model
{
    /** @use HasFactory<\Database\Factories\ClienteFactory> */
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
     * @return BelongsToMany<Empresa,Cliente,EmpresaCliente>
     */
    public function empresas(): BelongsToMany
    {
        /** @var BelongsToMany<Empresa,Cliente,EmpresaCliente> */
        return $this->BelongsToMany(Empresa::class,
            'empresas_clientes',
            'cliente_id',
            'empresa_id'
        )->using(EmpresaCliente::class);
    }
}
