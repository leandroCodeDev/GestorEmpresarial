<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PintCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pint:run
                            {params?* : Parâmetros personalizados para o Pint}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executa o Laravel Pint para formatar o código ';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (! app()->isLocal()) {
            $this->warn('Este comando só pode ser executado em ambiente local.');

            return Command::FAILURE;
        }

        $params = implode(' ', $this->argument('params'));

        $this->info("🎨 Executando Pint com os parâmetros: {$params}");
        $this->line('📚 Documentação oficial: https://laravel.com/docs/12.x/pint#running-pint');

        $command = "vendor/bin/pint {$params}";
        passthru($command, $status);

        return $status;
    }

    public function isHidden(): bool
    {
        return ! app()->isLocal();
    }
}
