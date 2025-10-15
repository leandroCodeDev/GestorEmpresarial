
import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router, RouterModule } from '@angular/router';
import {
  MatListItem,
  MatListItemTitle,
  MatNavList,
} from '@angular/material/list';

import { MatButtonModule } from '@angular/material/button';
import { SidenavService } from '../../../core/services/sidenav/sidenav-service';
import { ItemMenuInterface } from '../../../core/interfaces/ItemMenu/item-menu-interface';
import { MatIconModule } from '@angular/material/icon';



@Component({
  selector: 'app-menu-lateral',
  standalone: true,
  imports: [
    RouterModule,
    CommonModule,
    MatNavList,
    MatListItem,
    MatIconModule,
    MatListItemTitle,
    MatButtonModule,
  ],
  templateUrl: './menu-lateral.html',
  styleUrl: './menu-lateral.scss'
})
export class MenuLateral {
itensMenuFiltrado: ItemMenuInterface[] = [];
  itensMenu: ItemMenuInterface[] = [
    {
      rotulo: 'Home',
      icone: 'home',
      rota: '/home',
    },
    {
      rotulo: 'Listagem de Empresas',
      icone: 'business',
      rota: '/empresas',
    },
    {
      rotulo: 'Listagem de Funcionarios',
      icone: 'badge',
      rota: '/funcionarios',
    },
    {
      rotulo: 'Listagem de Clientes',
      icone: 'handshake',
      rota: '/clientes',
    },
  ];


  constructor(
    private router: Router,
    private sidenavService: SidenavService
  ) {}

  ngOnInit(): void {
    
  }

  
  closeSidenav() {
    if (
      this.sidenavService.sidenavMode === 'over' ||
      this.sidenavService.sidenavMode === 'push'
    ) {
      this.sidenavService.close();
    }
  }
}
