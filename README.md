# 🚀 Projeto Gestor Empresarial - API e Web

[![Docker](https://img.shields.io/badge/Docker-Ready-blue?logo=docker)](https://www.docker.com/)
[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?logo=laravel)](https://laravel.com/)
[![Angular](https://img.shields.io/badge/Angular-17+-DD0031?logo=angular)](https://angular.io/)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-SQL-blue?logo=postgresql)](https://www.postgresql.org/)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---

## 🧩 Descrição Geral

O **Gestor Empresarial** é um sistema **Full Stack** desenvolvido para o **Desafio Programador PHP/Angular**, com o objetivo de gerenciar **empresas, funcionários e clientes** de forma integrada.

A aplicação foi construída com:
- **Backend:** PHP 8.2+ com **Laravel 12**
- **Frontend:** **Angular 17+** e **Angular Material**
- **Banco de Dados:** **PostgreSQL**
- **Servidor Web:** **Apache 2.4+**
- **Containerização:** **Docker**

---

## 🧱 Funcionalidades Principais

### 🏢 Gerenciamento de Empresas
- CRUD completo de empresas.
- Exibição de funcionários e clientes vinculados.
- Relacionamento **N:N** com funcionários e clientes.

### 👨‍💼 Gerenciamento de Funcionários e Clientes
- CRUD completo de funcionários e clientes.
- Cada um pode pertencer a **uma ou mais empresas**.
- Upload de **documentos de identificação (PDF/JPG)**.
- Validação de campos para impedir **acentuação em login ou nome**.

### 🌐 Integração Front-end e Back-end
- Consumo da API REST pelo **Angular**.
- Tratamento genérico de erros.
- Interface web moderna para **cadastro, edição, listagem e exclusão**.

---

## 🧰 Estrutura do Projeto

```

GestorEmpresarial-Web/
│   ├── docker/
│   ├── src/                # Código-fonte Angular
│   ├── package.json
│   └── angular.json

GestorEmpresarial-API/
│   ├── app/                # Código-fonte Laravel
│   ├── routes/
│   ├── database/
│   ├── docker/
│   ├── composer.json
│   └── artisan

````

---

## ⚙️ Instalação e Execução

### 1️⃣ Clonar o repositório
```bash
git clone <URL_DO_REPOSITORIO>
cd <PASTA_DO_PROJETO>
````

### 2️⃣ Dar permissão de execução ao script

```bash
chmod +x start-containers.sh
```

### 3️⃣ Executar os containers Docker

```bash
./start-containers.sh
```

> Este script sobe os containers do Laravel (API), Angular (frontend) e banco de dados (PostgreSQL).

### 4️⃣ Acessar a aplicação

* **API Laravel:** [http://localhost:8000/api](http://localhost:8000/api)
* **Frontend Angular:** [http://localhost:4200](http://localhost:4200)

---

## 🧪 Testes

* **Framework:** PestPHP
* **Cobertura:** aproximadamente **74%** (testes de integração)
* **Banco:** SQLite em memória durante os testes
* **Motivo:** testes sem mocks, garantindo comportamento real das operações

> Os testes podem ser executados com:

```bash
php artisan test
```

---

## 💻 Qualidade e Padronização

O projeto segue boas práticas de código e utiliza ferramentas para garantir qualidade e consistência:

| Ferramenta       | Função                                         |
| ---------------- | ---------------------------------------------- |
| **Laravel Pint** | Padronização e formatação automática de código |
| **PHPStan**      | Análise estática e verificação de qualidade    |
| **PestPHP**      | Testes automatizados                           |
| **Docker**       | Ambientes isolados e reprodutíveis             |

---

## 🧱 Decisões Técnicas

* Criação de tabelas separadas para **clientes** e **funcionários**, permitindo evolução independente das entidades.
* Lógica de negócio concentrada em **Services**, evitando regras em **Controllers**.
* Optou-se por **não usar SoftDelete**.
* **Validações centralizadas** nas Requests.
* **Factories** e **Seeders** criados para geração de dados de teste.
* Uso de **Resources** para formatação de respostas JSON.

---

## 🪲 Observações e Bugs Conhecidos

Devido a limitação de tempo estamos cientes dos seguintes pontos


### Frontend

* Identificado **bug de duplo clique** em botões de busca (primeiro clique não dispara o evento).
* No Apache, acesso direto via URL completa pode causar erro *Not Found* (ajuste no `.htaccess` necessário).

---

## ⚠️ Débitos Técnicos

Devido a limitação de tempo estamos cientes dos seguintes pontos 

### 🔧 Backend

* Adicionar **testes unitários** complementares.
* Criar **padrão unificado de retorno da API**.
* Implementar **arquitetura de repositórios** mais robusta.
* Avaliar **herança entre User, Cliente e Funcionário**.
* Adicionar **documentação de API** (Swagger ou Scramble).

### 💡 Frontend

* Criar **testes unitários de componentes**.
* Modularizar componentes de **Cliente** e **Funcionário**, que possuem estrutura semelhante.

---

## 🌟 Pontos Positivos

### 🧱 Backend

* Uso dos **Resources** e **Requests** nativos do Laravel.
* **Factories e Seeders** para geração rápida de dados.
* Código **padronizado** e **analisado automaticamente**.
* **Separação clara** entre lógica de controle e de negócio.

### 🖥️ Frontend

* **Layout responsivo** e compatível com dispositivos móveis.
* **Design limpo e minimalista** com **Angular Material**.
* Utilização de **toasts** para feedback de eventos.
* Desenvolvimento com **TypeScript** e boas práticas.
* **Logo própria** integrada ao tema **Azure/Blue**.

---

## 📦 Ferramentas Utilizadas

| Categoria         | Ferramenta      |
| ----------------- | --------------- |
| Backend           | Laravel 12      |
| Frontend          | Angular 17      |
| Banco de Dados    | PostgreSQL      |
| Testes            | PestPHP         |
| Análise de Código | PHPStan         |
| Padronização      | Laravel Pint    |
| Containerização   | Docker + Apache |

---

## 🗃️ Estrutura do Script `start-containers.sh`

O script automatiza:

* Inicialização dos containers Docker (API, frontend e banco de dados).
* Execução de comandos de inicialização do Laravel (`composer install`, `php artisan migrate`, etc).
* Instalação das dependências do Angular (`npm install`).

> Deve ser executado na primeira inicialização do ambiente.

---

## 🧾 Observações

* Documentos enviados (PDF/JPG) são vinculados aos respectivos funcionários ou clientes.
* Uploads são **validados quanto ao tipo e formato**.
* Campos de **login** e **nome** não aceitam **acentuação**.

---

## 🧑‍💻 Autor

**Leandro Dias**
Desafio: *Programador Full Stack PHP / Angular*
📧 [[seu-email@exemplo.com](mailto:seu-email@exemplo.com)]
🔗 [GitHub do Projeto](https://github.com/seu-repositorio)

---

> 💡 *Este projeto foi desenvolvido com foco em boas práticas, clareza de código e arquitetura organizada, demonstrando conhecimento em desenvolvimento full stack e integração entre camadas.*

```

---

Deseja que eu adicione **badges extras** (ex: *Test Coverage*, *Build Passing*, *License MIT*) e **uma pequena seção com instruções de Postman e Swagger** para deixar o README ainda mais completo e visualmente profissional?
```
