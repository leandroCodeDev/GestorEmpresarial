<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PhpStanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phpstan:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executa o PHPStan para análise estática de código';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (! app()->isLocal()) {
            $this->warn('Este comando só pode ser executado em ambiente local.');

            return Command::FAILURE;
        }

        $this->info("Executando PHPStan com limite de memória '2G'...");

        $command = 'vendor/bin/phpstan analyse --memory-limit=2G';

        passthru($command, $status);

        return $status;
    }

    public function isHidden(): bool
    {
        return ! app()->isLocal();
    }
}
