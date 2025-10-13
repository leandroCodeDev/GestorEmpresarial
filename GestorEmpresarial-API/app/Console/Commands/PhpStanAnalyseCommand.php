<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PhpStanAnalyseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phpstan:analyse
                            {params* : Parâmetros personalizados para o PHPStan}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executa o PHPStan com parâmetros customizados (ex: phpstan:analyse --level=max src/)';

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

        $this->info('Executando PHPStan com as seguintes configurações:');
        $this->line('📚 Documentação oficial: https://phpstan.org/user-guide/command-line-usage');

        $command = "vendor/bin/phpstan analyse {$params}";

        passthru($command, $status);

        return $status;
    }

    public function isHidden(): bool
    {
        return ! app()->isLocal();
    }
}
