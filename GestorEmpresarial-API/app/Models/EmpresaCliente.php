<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EmpresaCliente extends Pivot
{
    protected $table = 'empresas_clientes';
    //
}
