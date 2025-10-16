// ...existing code...
# Projeto Gestão de Empresas - API

Descrição
- API backend em Laravel para gestão de empresas, clientes e funcionários. Foco em endpoints REST para CRUD, upload de documentos e recursos JSON via Laravel Resources. Projetado para rodar localmente com Composer/NPM ou em containers Docker para produção.

Principais funcionalidades
- Gerenciamento de empresas, clientes e funcionários (CRUD).
- Upload e armazenamento de documentos por cliente/funcionário.
- Recursos (API Resources) para padronizar respostas JSON.
- Testes automatizados com PestPHP.
- Suporte a execução via Docker / docker-compose.

Dependências (resumo)
- Requisitos de sistema:
  - PHP 8.2 ou superior
  - Composer
  - Node.js 18+ (NPM ou Yarn)
  - Banco de dados compatível (MySQL, PostgreSQL ou SQLite)
  - Docker / Docker Compose (opcional para ambiente em containers)
- Extensões PHP recomendadas:
  - ext-pdo, ext-mbstring, ext-tokenizer, ext-xml, ext-ctype, ext-json, ext-fileinfo, ext-openssl, ext-curl, ext-zip
- Dependências do PHP / Composer:
  - Ver lista completa em composer.json. Para inspecionar localmente:
    - composer show --installed
    - cat composer.json
- Dependências do Node / NPM:
  - Ver lista completa em package.json. Para inspecionar localmente:
    - npm ls --depth=0
    - cat package.json

Instalação (local)
1. Clone e entre na pasta do projeto
   - git clone <repo> && cd GestorEmpresarial-API
2. Copie e configure .env
   - cp .env.example .env
3. Instale dependências PHP e JS
   - composer install
   - npm install
4. Gere a chave Laravel e rode migrations
   - php artisan key:generate
   - php artisan migrate --force

Scripts úteis (definidos em composer.json e package.json)
- Setup (instala tudo e roda migrations + build front): sail up -d
- Ambiente dev (serve, filas, vite): sail up -d
- Testes: sail artisan test

API principal
- Recursos REST: routes/api.php (empresas, clientes, funcionários)
- Upload de documentos:
  - Clientes: POST /api/clientes/{id}/documento
  - Funcionários: POST /api/funcionarios/{id}/documento
- Formatos de resposta: Resources em app/Http/Resources

Testes
- Framework: PestPHP (ver phpunit.xml para configuração de ambiente)
- Executar: sail artisan test

Armazenamento e uploads
- Disk default: conforme .env.example (FILESYSTEM_DISK)
- Storage público: storage/app/public

Observações operacionais
- CORS: config/cors.php
- Autoload PSR-4: composer.json

Deploy / Docker
- Compose para desenvolvimento: compose.yaml
- Dockerfile produção: docker/production/Dockerfile
- Public webroot: public/index.php

Contribuição
- Siga as convenções PSR e formulário de commits do projeto.
- Rode testes localmente antes de abrir PR: composer test

Contato
- Mantido por: Leandro Dias (ver README original do repositório)
