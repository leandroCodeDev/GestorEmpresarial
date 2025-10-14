import { Routes } from '@angular/router';

export const routes: Routes = [
    {
    path: 'home',
    loadComponent: () =>
      import('./pages/home/home').then((c) => c.Home),
  },
  {
    path: '',
    redirectTo: '/home',
    pathMatch: 'full',
  },

];
