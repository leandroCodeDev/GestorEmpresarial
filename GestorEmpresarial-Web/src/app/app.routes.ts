import { Routes } from '@angular/router';

export const routes: Routes = [
    {
    path: 'home',
    loadComponent: () =>
      import('./pages/home/home').then((c) => c.Home),
  },
  {
    path: 'empresas',
    loadComponent: () =>
      import('./pages/empresas/empresas').then((c) => c.Empresas),
  },
  {
    path: 'clientes',
    loadComponent: () =>
      import('./pages/clientes/clientes').then((c) => c.Clientes),
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
        path: ':id/visualizar',
        loadComponent: () =>
        import('./pages/visualizar-funcionarios/visualizar-funcionarios').then((c) => c.VisualizarFuncionarios),
      },
      {
        path: ':id/editar',
        loadComponent: () =>
        import('./pages/editar-funcionarios/editar-funcionarios').then((c) => c.EditarFuncionarios),
      },
    ]
  },
  {
    path: '',
    redirectTo: '/home',
    pathMatch: 'full',
  },

];
