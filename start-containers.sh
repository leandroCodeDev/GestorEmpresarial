#!/bin/bash

# Sai imediatamente se houver erro
set -e

# Diretórios dos projetos
PROJETO1="./GestorEmpresarial-API"
PROJETO2="./GestorEmpresarial-Web"


echo "Subindo containers do Projeto 1..."
(cd $PROJETO1 && cp ./.env.example ./.env)
(cd $PROJETO1 && docker compose up -d)
(cd $PROJETO1 && docker compose exec -it laravel.test php artisan migrate:refresh )
(cd $PROJETO1 && docker compose exec -it laravel.test php artisan db:seed EmpresaSeeder )


echo "Subindo containers do Projeto 2..."
(cd $PROJETO2 && docker compose up -d)

echo "Todos os containers foram iniciados com sucesso!"
