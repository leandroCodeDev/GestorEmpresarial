<?php

use App\Models\Empresa;
use App\Models\Funcionario;
use Illuminate\Http\UploadedFile;

it('retorna a lista de funcionarios', function () {
    $funcionarios = Funcionario::factory()->count(5)->create();
    $response = $this->get('/api/funcionarios');

    $response->assertOk()
        ->assertJsonCount($funcionarios->count());
});

it('retorna um funcionario específico', function () {
    Funcionario::factory()->create();
    $funcionario = Funcionario::get()->first();

    $response = $this->get('/api/funcionarios/'.$funcionario->id);

    $response->assertOk()
        ->assertJsonFragment(['nome' => $funcionario->nome])
        ->assertJsonFragment(['cpf' => $funcionario->cpf])
        ->assertJsonFragment(['endereco' => $funcionario->endereco]);
});

it('cria um novo funcionario', closure: function () {
    $empresa = Empresa::factory()->create();
    Storage::fake('local');
    $file = UploadedFile::fake()->create('comprovante.pdf', 200, 'application/pdf');
    $funcionario = Funcionario::factory()->make();
    $funcionario->documento_path = $file;
    $funcionario->login = 'funcionario Criado';

    $response = $this->post('/api/funcionarios', [
        'nome' => $funcionario->nome,
        'login' => $funcionario->login,
        'cpf' => $funcionario->cpf,
        'email' => $funcionario->email,
        'senha' => $funcionario->senha,
        'endereco' => $funcionario->endereco,
        'documento' => $file,
        'empresas' => [$empresa->id],
    ]);

    $response->assertCreated()
        ->assertJsonFragment(['nome' => $funcionario->nome])
        ->assertJsonFragment(['cpf' => $funcionario->cpf])
        ->assertJsonFragment(['endereco' => $funcionario->endereco]);
});

it('atualiza um funcionario existente', function () {
    Empresa::factory()->create();
    Funcionario::factory()->create();
    $empresa = Empresa::get()->first();
    $funcionario = Funcionario::get()->first();
    Storage::fake('local');

    $funcionario->login = 'funcionario atualizado';

    $response = $this->putJson('/api/funcionarios/'.$funcionario->id, [
        'nome' => $funcionario->nome,
        'login' => $funcionario->login,
        'cpf' => $funcionario->cpf,
        'email' => $funcionario->email,
        'senha' => $funcionario->senha,
        'endereco' => $funcionario->endereco,
        'empresas' => [$empresa->id],
    ]);

    $response->assertOk()
        ->assertJsonFragment(['nome' => $funcionario->nome])
        ->assertJsonFragment(['cpf' => $funcionario->cpf])
        ->assertJsonFragment(['endereco' => $funcionario->endereco]);
});

it('remove um funcionario', function () {
    Funcionario::factory()->create();
    $funcionario = Funcionario::get()->first();

    $response = $this->deleteJson('/api/funcionarios/'.$funcionario->id);

    $response->assertNoContent();
});

it('envia um documento para o funcionario', function () {
    Storage::fake('local');
    $file = UploadedFile::fake()->create('comprovante.pdf', 200, 'application/pdf');
    Funcionario::factory()->create();
    $funcionario = Funcionario::get()->first();
    $funcionario->documento_path = $file;

    $response = $this->post('/api/funcionarios/'.$funcionario->id.'/documento', [
        'documento' => $file,
    ]);

    $response->assertCreated()
        ->assertJsonFragment([
            'documento' => asset('storage/funcionarios/'.$file->hashName()),
        ]);
});
