import { Routes } from '@angular/router';

export const routes: Routes = [
    {
    path: 'home',
    loadComponent: () =>
      import('./pages/home/home').then((c) => c.Home),
  },
  {
    path: 'empresas',
    children: [
      {
        path: '',
        loadComponent: () =>
        import('./pages/empresas/empresas').then((c) => c.Empresas),
      },
      {
        path: 'cadastro',
        loadComponent: () =>
        import('./pages/cadastro-empresas/cadastro-empresas').then((c) => c.CadastroEmpresas),
      },
      {
        path: ':id',
        loadComponent: () =>
        import('./pages/cadastro-empresas/cadastro-empresas').then((c) => c.CadastroEmpresas),
      },
    ]
    
  },
  {
    path: 'clientes',
    children: [
      {
        path: '',
        loadComponent: () =>
        import('./pages/clientes/clientes').then((c) => c.Clientes),
      },
      {
        path: 'cadastro',
        loadComponent: () =>
        import('./pages/cadastro-clientes/cadastro-clientes').then((c) => c.CadastroClientes),
      },
      {
        path: ':id',
        loadComponent: () =>
         import('./pages/cadastro-clientes/cadastro-clientes').then((c) => c.CadastroClientes),
      },
    ]
  },
  {
    path: 'funcionarios',
     children: [
      {
        path: '',
        loadComponent: () =>
        import('./pages/funcionarios/funcionarios').then((c) => c.Funcionarios),
      },
      {
        path: 'cadastro',
        loadComponent: () =>
        import('./pages/cadastro-funcionarios/cadastro-funcionarios').then((c) => c.CadastroFuncionarios),
      },
      {
        path: ':id',
        loadComponent: () =>
        import('./pages/cadastro-funcionarios/cadastro-funcionarios').then((c) => c.CadastroFuncionarios),
      },
    ]
  },
  {
    path: '',
    redirectTo: '/home',
    pathMatch: 'full',
  },

];
