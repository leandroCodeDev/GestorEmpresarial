import { Component, signal } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { LoadingService } from './core/services/loading/loading-service';
import { SidenavService } from './core/services/sidenav/sidenav-service';
import { Loading } from './shared/components/loading/loading';
import { CommonModule } from '@angular/common';
import { MatDrawerMode, MatSidenavModule } from '@angular/material/sidenav';
import { MatIconModule } from '@angular/material/icon';
import { MenuLateral } from './shared/components/menu-lateral/menu-lateral';
import { Toolbar } from './shared/components/toolbar/toolbar';

@Component({
  selector: 'app-root',
  imports: [
    RouterOutlet,
    Loading,
    RouterOutlet,
    MenuLateral,
    Toolbar,
    CommonModule,
    MatSidenavModule,
    MatIconModule,
  ],
  templateUrl: './app.html',
  styleUrl: './app.scss'
})
export class App {
  protected readonly title = signal('GestorEmpresarial-Web');
  sidenavMode: MatDrawerMode = 'side';
  showMenuLateral = true;
  showToolbar = true;
  opened = true;
  constructor(
    private loadingService: LoadingService,
    private sidenavService: SidenavService,

  ){
      this.sidenavService.opened$.subscribe((isOpened) => {
      this.opened = isOpened;
    });
  }

}
