<?php

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Http\Requests\UploadedDocumentoRequest;
use App\Http\Resources\ClienteCollection;
use App\Http\Resources\ClienteResource;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Services\ClienteService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;


beforeEach(function () {
    // Cria mock do service
    $this->mockService = Mockery::mock(ClienteService::class);
    $this->app->instance(ClienteService::class, $this->mockService);
});

afterEach(function () {
    Mockery::close();
});

it('retorna a lista de clientes', function () {
    $clientes = Cliente::factory()->count(5)->make();
    $clientesResource = new ClienteCollection($clientes);

    $this->mockService
        ->shouldReceive('buscarTodos')
        ->once()
        ->andReturn($clientesResource);

    $response = $this->getJson('/api/clientes');

    $response->assertOk()
        ->assertJsonCount($clientes->count());
});

it('retorna um cliente específico', function () {
    Storage::fake('local');
    $file = UploadedFile::fake()->create('comprovante.pdf', 200, 'application/pdf');
    $cliente = Cliente::factory()->make();
    $cliente->documento_path = $file;
    $clientesResource = new ClienteResource($cliente);

    $this->mockService
        ->shouldReceive('buscarPorId')
        ->with(10)
        ->once()
        ->andReturn($clientesResource);

    $response = $this->get('/api/clientes/10');


    $clienteArray = $cliente->toArray();
    unset($clienteArray['senha']);
    $response->assertOk()
        ->assertJsonFragment($clienteArray);
});

it('cria um novo cliente', closure: function () {
    $empresa = Empresa::factory()->create();
    Storage::fake('local');
    $file = UploadedFile::fake()->create('comprovante.pdf', 200, 'application/pdf');
    $cliente = Cliente::factory()->make();
    $cliente->documento_path = $file;

    $clientesResource = new ClienteResource($cliente);

    $this->mockService
        ->shouldReceive('criar')
        ->with(Mockery::type(StoreClienteRequest::class))
        ->once()
        ->andReturn($clientesResource);

    $response = $this->post('/api/clientes', [
        'nome' => $cliente->nome,
        'login' => $cliente->login,
        'cpf' => $cliente->cpf,
        'email' => $cliente->email,
        'senha' => $cliente->senha,
        'endereco' => $cliente->endereco,
        'documento' => $file,
        'empresas' => [$empresa->id]
    ]);

    $clienteArray = $cliente->toArray();
    unset($clienteArray['senha']);
    $clienteArray['documento'] =  asset('storage/'.$file);
    $response->assertCreated()
        ->assertJsonFragment($clienteArray);
});

it('atualiza um cliente existente', function () {
    $empresa = Empresa::factory()->create();
    Storage::fake('local');
    $file = UploadedFile::fake()->create('comprovante.pdf', 200, 'application/pdf');
    $cliente = Cliente::factory()->make();
    $cliente->login = 'clienteAlterado';
    $cliente->documento_path = $file;

    $clientesResource = new ClienteResource($cliente);

    $this->mockService
        ->shouldReceive('atualizar')
        ->with(Mockery::type(UpdateClienteRequest::class), 5)
        ->once()
        ->andReturn($clientesResource);

    $response = $this->putJson('/api/clientes/5', [
        'nome' => $cliente->nome,
        'login' => $cliente->login,
        'cpf' => $cliente->cpf,
        'email' => $cliente->email,
        'senha' => $cliente->senha,
        'endereco' => $cliente->endereco,
        'empresas' => [$empresa->id]
    ]);

    $clienteArray = $cliente->toArray();
    unset($clienteArray['senha']);
    $clienteArray['documento'] =  asset('storage/'.$file);
    $response->assertOk()
        ->assertJsonFragment($clienteArray);
});

it('remove um cliente', function () {
    $this->mockService
        ->shouldReceive('excluir')
        ->with(5)
        ->once()
        ->andReturnTrue();

    $response = $this->deleteJson('/api/clientes/5');

    $response->assertNoContent();
});

it('envia um documento para o cliente', function () {
    Storage::fake('local');
    $file = UploadedFile::fake()->create('comprovante.pdf', 200, 'application/pdf');
    $cliente = Cliente::factory()->make();
    $cliente->documento_path = $file;

    $clientesResource = new ClienteResource($cliente);

    $this->mockService
        ->shouldReceive('enviarDocumento')
        ->with(Mockery::type(UploadedDocumentoRequest::class), 5)
        ->once()
        ->andReturn($clientesResource);

    $response = $this->post('/api/clientes/5/documento', [
        'documento' => $file,
    ]);

    $clienteArray = $cliente->toArray();
    unset($clienteArray['senha']);
    $clienteArray['documento'] =  asset('storage/'.$file);
    $response->assertCreated()
        ->assertJsonFragment($clienteArray);
});
