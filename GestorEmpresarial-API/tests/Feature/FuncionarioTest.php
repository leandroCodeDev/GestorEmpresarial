<?php

use App\Http\Requests\StoreFuncionarioRequest;
use App\Http\Requests\UpdateFuncionarioRequest;
use App\Http\Requests\UploadedDocumentoRequest;
use App\Http\Resources\FuncionarioCollection;
use App\Http\Resources\FuncionarioResource;
use App\Models\Empresa;
use App\Models\Funcionario;
use App\Services\FuncionarioService;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    // Cria mock do service
    $this->mockService = Mockery::mock(FuncionarioService::class);
    $this->app->instance(FuncionarioService::class, $this->mockService);
});

afterEach(function () {
    Mockery::close();
});

it('retorna a lista de funcionarios', function () {
    $funcionarios = Funcionario::factory()->count(5)->make();
    $funcionariosResource = new FuncionarioCollection($funcionarios);

    $this->mockService
        ->shouldReceive('buscarTodos')
        ->once()
        ->andReturn($funcionariosResource);

    $response = $this->getJson('/api/funcionarios');

    $response->assertOk()
        ->assertJsonCount($funcionarios->count());
});

it('retorna um funcionario específico', function () {
    Storage::fake('local');
    $file = UploadedFile::fake()->create('comprovante.pdf', 200, 'application/pdf');
    $funcionario = Funcionario::factory()->make();
    $funcionario->documento_path = $file;
    $funcionariosResource = new FuncionarioResource($funcionario);

    $this->mockService
        ->shouldReceive('buscarPorId')
        ->with(10)
        ->once()
        ->andReturn($funcionariosResource);

    $response = $this->get('/api/funcionarios/10');


    $funcionarioArray = $funcionario->toArray();
    unset($funcionarioArray['senha']);
    $response->assertOk()
        ->assertJsonFragment($funcionarioArray);
});

it('cria um novo funcionario', closure: function () {
    $empresa = Empresa::factory()->create();
    Storage::fake('local');
    $file = UploadedFile::fake()->create('comprovante.pdf', 200, 'application/pdf');
    $funcionario = Funcionario::factory()->make();
    $funcionario->documento_path = $file;
    $funcionario->login = 'funcionarioCriado';
    $funcionariosResource = new FuncionarioResource($funcionario);

    $this->mockService
        ->shouldReceive('criar')
        ->with(Mockery::type(StoreFuncionarioRequest::class))
        ->once()
        ->andReturn($funcionariosResource);

    $response = $this->post('/api/funcionarios', [
        'nome' => $funcionario->nome,
        'login' => $funcionario->login,
        'cpf' => $funcionario->cpf,
        'email' => $funcionario->email,
        'senha' => $funcionario->senha,
        'endereco' => $funcionario->endereco,
        'documento' => $file,
        'empresas' => [$empresa->id]
    ]);

    $funcionarioArray = $funcionario->toArray();
    unset($funcionarioArray['senha']);
    $funcionarioArray['documento'] =  asset('storage/'.$file);
    $response->assertCreated()
        ->assertJsonFragment($funcionarioArray);
});

it('atualiza um funcionario existente', function () {
    $empresa = Empresa::factory()->create();
    Storage::fake('local');
    $file = UploadedFile::fake()->create('comprovante.pdf', 200, 'application/pdf');
    $funcionario = Funcionario::factory()->make();
    $funcionario->login = 'funcionarioAlterado';
    $funcionario->documento_path = $file;

    $funcionariosResource = new FuncionarioResource($funcionario);

    $this->mockService
        ->shouldReceive('atualizar')
        ->with(Mockery::type(UpdateFuncionarioRequest::class), 5)
        ->once()
        ->andReturn($funcionariosResource);

    $response = $this->putJson('/api/funcionarios/5', [
        'nome' => $funcionario->nome,
        'login' => $funcionario->login,
        'cpf' => $funcionario->cpf,
        'email' => $funcionario->email,
        'senha' => $funcionario->senha,
        'endereco' => $funcionario->endereco,
        'empresas' => [$empresa->id]
    ]);

    $funcionarioArray = $funcionario->toArray();
    unset($funcionarioArray['senha']);
    $funcionarioArray['documento'] =  asset('storage/'.$file);
    $response->assertOk()
        ->assertJsonFragment($funcionarioArray);
});

it('remove um funcionario', function () {
    $this->mockService
        ->shouldReceive('excluir')
        ->with(5)
        ->once()
        ->andReturnTrue();

    $response = $this->deleteJson('/api/funcionarios/5');

    $response->assertNoContent();
});

it('envia um documento para o funcionario', function () {
    Storage::fake('local');
    $file = UploadedFile::fake()->create('comprovante.pdf', 200, 'application/pdf');
    $funcionario = Funcionario::factory()->make();
    $funcionario->documento_path = $file;

    $funcionariosResource = new FuncionarioResource($funcionario);

    $this->mockService
        ->shouldReceive('enviarDocumento')
        ->with(Mockery::type(UploadedDocumentoRequest::class), 5)
        ->once()
        ->andReturn($funcionariosResource);

    $response = $this->post('/api/funcionarios/5/documento', [
        'documento' => $file,
    ]);

    $funcionarioArray = $funcionario->toArray();
    unset($funcionarioArray['senha']);
    $funcionarioArray['documento'] =  asset('storage/'.$file);
    $response->assertCreated()
        ->assertJsonFragment($funcionarioArray);
});
