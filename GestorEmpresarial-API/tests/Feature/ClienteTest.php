<?php

use App\Models\Cliente;
use App\Models\Empresa;
use Illuminate\Http\UploadedFile;

it('retorna a lista de clientes', function () {
    $clientes = Cliente::factory()->count(5)->create();

    $response = $this->getJson('/api/clientes');

    $response->assertOk()
        ->assertJsonCount($clientes->count());
});

it('retorna um cliente específico', function () {
    Cliente::factory()->create();
    $cliente = Cliente::get()->first();

    $response = $this->get('/api/clientes/'.$cliente->id);

    $response->assertOk()
        ->assertJsonFragment(['nome' => $cliente->nome])
        ->assertJsonFragment(['cpf' => $cliente->cpf])
        ->assertJsonFragment(['endereco' => $cliente->endereco]);
});

it('cria um novo cliente', closure: function () {
    $empresa = Empresa::factory()->create();
    Storage::fake('local');
    $file = UploadedFile::fake()->create('comprovante.pdf', 200, 'application/pdf');
    $cliente = Cliente::factory()->make();
    $cliente->documento_path = $file;
    $cliente->login = 'clienteCriado';

    $response = $this->post('/api/clientes', [
        'nome' => $cliente->nome,
        'login' => $cliente->login,
        'cpf' => $cliente->cpf,
        'email' => $cliente->email,
        'senha' => $cliente->senha,
        'endereco' => $cliente->endereco,
        'documento' => $file,
        'empresas' => [$empresa->id],
    ]);

    $response->assertCreated()
        ->assertJsonFragment(['nome' => $cliente->nome])
        ->assertJsonFragment(['cpf' => $cliente->cpf])
        ->assertJsonFragment(['endereco' => $cliente->endereco]);
});

it('atualiza um cliente existente', function () {
    Empresa::factory()->create();
    Cliente::factory()->create();
    $empresa = Empresa::get()->first();
    $cliente = Cliente::get()->first();
    Storage::fake('local');

    $cliente->login = 'cliente atualizado';

    $response = $this->putJson('/api/clientes/'.$cliente->id, [
        'nome' => $cliente->nome,
        'login' => $cliente->login,
        'cpf' => $cliente->cpf,
        'email' => $cliente->email,
        'senha' => $cliente->senha,
        'endereco' => $cliente->endereco,
        'empresas' => [$empresa->id],
    ]);

    $response->assertOk()
        ->assertJsonFragment(['nome' => $cliente->nome])
        ->assertJsonFragment(['cpf' => $cliente->cpf])
        ->assertJsonFragment(['endereco' => $cliente->endereco]);
});

it('remove um cliente', function () {
    Cliente::factory()->create();
    $cliente = Cliente::get()->first();

    $response = $this->delete('/api/clientes/'.$cliente->id);

    $response->assertNoContent();
});

it('envia um documento para o cliente', function () {
    Storage::fake('local');
    $file = UploadedFile::fake()->create('comprovante.pdf', 200, 'application/pdf');
    Cliente::factory()->create();
    $cliente = Cliente::get()->first();
    $cliente->documento_path = $file;

    $response = $this->post('/api/clientes/'.$cliente->id.'/documento', [
        'documento' => $file,
    ]);

    $response->assertCreated()
        ->assertJsonFragment([
            'documento' => asset('storage/clientes/'.$file->hashName()),
        ]);
});
