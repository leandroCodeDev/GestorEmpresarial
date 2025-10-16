<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Empresa::factory()
            ->count(3)
            ->hasClientes(3)
            ->hasFuncionarios(3)
            ->create();
    }
}
