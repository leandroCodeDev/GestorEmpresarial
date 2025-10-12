<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EmpresaFuncionario extends Pivot
{
    protected $table = 'empresas_funcionarios';
    //
}
