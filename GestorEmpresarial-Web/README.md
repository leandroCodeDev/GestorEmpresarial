// ...existing code...
# GestorEmpresarial-Web

Aplicação SPA construída com Angular 20 para gerenciar Empresas, Funcionários e Clientes. Este README resume como rodar, testar e entender a estrutura do projeto com links diretos para os arquivos e componentes principais.

## Visão geral rápida

- Frontend: Angular (standalone components, ReactiveForms).
- Estilos: SCSS central em [src/styles.scss](src/styles.scss).
- Rotas carregadas sob demanda em [`routes`](src/app/app.routes.ts).
- Interceptadores e serviços para loading/effects e API em [src/app/core/services](src/app/core/services).

Arquivos-chave:
- Configuração da aplicação: [`appConfig`](src/app/app.config.ts) — [src/app/app.config.ts](src/app/app.config.ts)
- Componente root: [`App`](src/app/app.ts) — [src/app/app.ts](src/app/app.ts)
- Entrypoint: [src/main.ts](src/main.ts)
- Rotas: [`routes`](src/app/app.routes.ts) — [src/app/app.routes.ts](src/app/app.routes.ts)
- Package: [package.json](package.json)
- Angular CLI config: [angular.json](angular.json)

## Estrutura importante

- Páginas (rotas lazy-loaded): `src/app/pages/*`  
  Exemplos: [Empresas](src/app/pages/empresas/empresas.ts), [Funcionários](src/app/pages/funcionarios/funcionarios.ts), [Clientes](src/app/pages/clientes/clientes.ts)
- Componentes compartilhados: `src/app/shared/components/*`  
  Exemplos: [Toolbar](src/app/shared/components/toolbar/toolbar.ts), [Menu Lateral](src/app/shared/components/menu-lateral/menu-lateral.ts), [Loading](src/app/shared/components/loading/loading.ts), [Dialog](src/app/shared/components/dialog/dialog.ts)
- Serviços core:
  - [`LoadingService`](src/app/core/services/loading/loading-service.ts) — controla indicador de carregamento.
  - [`SidenavService`](src/app/core/services/sidenav/sidenav-service.ts) — controla estado do sidenav.
  - Serviços de API: [`EmpresaService`](src/app/core/services/empresa/empresa-service.ts), [`FuncionarioService`](src/app/core/services/funcionario/funcionario-service.ts), [`ClienteService`](src/app/core/services/cliente/cliente-service.ts)
- Interceptor:
  - [`LoadingInterceptor`](src/app/core/interceptors/loading.interceptor.ts) — mostra/oculta o loading durante requisições HTTP.

## Rodando localmente (desenvolvimento)

1. Instalar dependências:
```bash
npm install
```

2. Rodar servidor de desenvolvimento:
```bash
npm run start
```
A aplicação será servida pelo Angular dev server. Por padrão o launcher no VS Code aponta para `http://localhost:4200/` (ver [/.vscode/launch.json](.vscode/launch.json)).

3. Abrir a app no navegador: http://localhost:4200/

## Build de produção

- Build normal:
```bash
npm run build
```
- Configuração de build está em [angular.json](angular.json). Os estilos globais incluem [src/styles.scss](src/styles.scss) e bibliotecas externas configuradas em `angular.json`.

## Docker

Este projeto inclui um Dockerfile para build + servir via Apache e um docker-compose:

- Dockerfile (build e Apache): [docker/angular/Dockerfile](docker/angular/Dockerfile)
- Compose: [docker-compose.yml](docker-compose.yml)

Para buildar e subir pelo Docker Compose:
```bash
docker compose up --build
```
O container publica a aplicação na porta mapeada `4201:80` conforme `docker-compose.yml`.
