import { Component, signal } from '@angular/core';
import { NavigationCancel, NavigationEnd, NavigationError, NavigationStart, Router, RouterOutlet } from '@angular/router';
import { LoadingService } from './core/services/loading/loading-service';
import { SidenavService } from './core/services/sidenav/sidenav-service';
import { Loading } from './shared/components/loading/loading';
import { CommonModule } from '@angular/common';
import { MatDrawerMode, MatSidenavModule } from '@angular/material/sidenav';
import { MatIconModule } from '@angular/material/icon';
import { MenuLateral } from './shared/components/menu-lateral/menu-lateral';
import { Toolbar } from './shared/components/toolbar/toolbar';
import { BreakpointObserver } from '@angular/cdk/layout';

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

  private navigationCount = 0;

  constructor(
    private loadingService: LoadingService,
    private sidenavService: SidenavService,
    private router: Router,
    private breakpointObserver: BreakpointObserver

  ){
      this.sidenavService.opened$.subscribe((isOpened) => {
      this.opened = isOpened;
    });
  }
  ngOnInit(): void {
    this.router.events.subscribe((event) => {
      if (event instanceof NavigationStart) {
        this.navigationCount++;
        this.loadingService.show();
      }
      if (
        event instanceof NavigationEnd ||
        event instanceof NavigationCancel ||
        event instanceof NavigationError
      ) {
        this.navigationCount--;
        if (this.navigationCount === 0) {
          this.loadingService.hide();
        }
      }
    });

    this.breakpointObserver
      .observe(['(max-width: 1024px)'])
      .subscribe((result) => {
        if (result.breakpoints['(max-width: 1024px)']) {
          this.sidenavMode = 'over';
          this.opened = false;
        } else {
          this.sidenavMode = 'side';
          this.opened = true;
        }
        this.sidenavService.setSidenavMode(this.sidenavMode);
      });
  }
}
