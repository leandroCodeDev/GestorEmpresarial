<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PhpStanClearCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phpstan:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpa o cache do PHPStan';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (! app()->isLocal()) {
            $this->warn('Este comando só pode ser executado em ambiente local.');

            return Command::FAILURE;
        }

        $this->info('Limpando o cache do PHPStan...');

        $command = 'vendor/bin/phpstan clear-result-cache';

        passthru($command, $status);

        return $status;
    }

    public function isHidden(): bool
    {
        return ! app()->isLocal();
    }
}
