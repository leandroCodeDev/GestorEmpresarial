<?php

use App\Http\Requests\UpdateEmpresaRequest;
use App\Http\Resources\EmpresaCollection;
use App\Http\Resources\EmpresaResource;
use App\Models\Empresa;
use App\Services\EmpresaService;
use Database\Seeders\EmpresaSeeder;
use Illuminate\Testing\TestResponse;
use Mockery;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;
use function Pest\Laravel\deleteJson;



afterEach(function () {
    Mockery::close();
});

it('retorna a lista de empresas', function () {
    $empresas = Empresa::factory()->count(10)->create();

    $response = $this->get('/api/empresas');

    $response->assertOk()
        ->assertJsonCount($empresas->count());
});

it('retorna uma empresa específica', function () {
    $this->seed(EmpresaSeeder::class);
    $empresa = Empresa::get()->first();

    $response = $this->get('/api/empresas/'.$empresa->id);


    $response->assertOk()
        ->assertJsonFragment(['nome' => $empresa->nome])
        ->assertJsonFragment(['cnpj' => $empresa->cnpj]);
});

it('cria uma nova empresa', function () {
    $dados = Empresa::factory()->make();
    $dados->nome = 'Nova Empresa';
    $dados->endereco = 'novo endereço';
    $empresaCriada = $dados;

    $response = $this->post('/api/empresas', [
        "nome" => $dados->nome,
        "cnpj" => $dados->cnpj,
        "endereco" => $dados->endereco
    ]);

    $response->assertCreated()
        ->assertJsonFragment(['nome' => $empresaCriada->nome])
        ->assertJsonFragment(['cnpj' => $empresaCriada->cnpj]);
});

it('atualiza uma empresa existente', function () {
    $dados = Empresa::factory()->create();
    $empresa = Empresa::get()->first();
    $empresa->nome = 'Empresa atualizado';
    $empresa->endereco = 'endereço atualizado';

    $response = $this->put('/api/empresas/'.$empresa->id, [
        'nome' => $empresa->nome,
        'cnpj' => $empresa->cnpj,
        'endereco' => $empresa->endereco
    ]);

    $response->assertOk()
        ->assertJsonFragment(['nome' => $empresa->nome])
        ->assertJsonFragment(['cnpj' => $empresa->cnpj])
        ->assertJsonFragment(['endereco' => $empresa->endereco]);
});

it('remove uma empresa', function () {
    Empresa::factory()->create();
    $empresa = Empresa::get()->first();

    $response = $this->delete('/api/empresas/'.$empresa->id);

    $response->assertNoContent();

});
