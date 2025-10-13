<?php

use App\Http\Requests\UpdateEmpresaRequest;
use App\Http\Resources\EmpresaCollection;
use App\Http\Resources\EmpresaResource;
use App\Models\Empresa;
use App\Services\EmpresaService;
use Illuminate\Testing\TestResponse;
use Mockery;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;
use function Pest\Laravel\deleteJson;

beforeEach(function () {
    // Cria um mock do service
    $this->mockService = Mockery::mock(EmpresaService::class);
    $this->app->instance(EmpresaService::class, $this->mockService);
});

afterEach(function () {
    Mockery::close();
});

it('retorna a lista de empresas', function () {
    $empresas = Empresa::factory()->count(10)->make();
    $empresaResource = new EmpresaCollection($empresas);


    $this->mockService
        ->shouldReceive('buscarTodos')
        ->once()
        ->andReturn($empresaResource);

    $response = getJson('/api/empresas');

    $response->assertOk()
        ->assertJsonCount($empresas->count());
});

it('retorna uma empresa específica', function () {
    $dados = Empresa::factory()->make();
    $empresaResource = new EmpresaResource($dados);
    $this->mockService
        ->shouldReceive('buscarPorId')
        ->with(10)
        ->once()
        ->andReturn($empresaResource);

    $response = $this->get('/api/empresas/10');

    $response->assertOk()
        ->assertJsonFragment($dados->toArray());
});

it('cria uma nova empresa', function () {
    $dados = Empresa::factory()->make();
    $dados->nome = 'Nova Empresa';
    $empresaCriada = $dados;
    $empresaResource = new EmpresaResource($empresaCriada);

    $this->mockService
        ->shouldReceive('salvar')
        ->once()
        ->andReturn($empresaResource);

    $response = $this->post('/api/empresas', [
        "nome" => $dados->nome,
        "cnpj" => $dados->cnpj,
        "endereco" => $dados->endereco
    ]);

    $response->assertCreated()
        ->assertJsonFragment($empresaCriada->toArray());
});

it('atualiza uma empresa existente', function () {
    $dados = Empresa::factory()->make();
    $empresaAtualizada = (new Empresa())->fill(
        [
            'nome' => 'Empresa Atualizada',
            'endereco' => "novo endereço"
        ]);
    $empresaResource = new EmpresaResource($empresaAtualizada);

    $this->mockService
        ->shouldReceive('atualizar')
        ->with(Mockery::type(UpdateEmpresaRequest::class), 5)
        ->once()
        ->andReturn($empresaResource);

    $response = $this->put('/api/empresas/5', $dados->toArray());

    $response->assertOk()
        ->assertJsonFragment(['nome' => 'Empresa Atualizada','endereco' => "novo endereço"]);
});

it('remove uma empresa', function () {
    $this->mockService
        ->shouldReceive('remover')
        ->with(5)
        ->once()
        ->andReturnTrue();

    $response = $this->delete('/api/empresas/5');

    $response->assertNoContent();
});
