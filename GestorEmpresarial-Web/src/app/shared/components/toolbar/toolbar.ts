import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { MatDialog } from '@angular/material/dialog';
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatIconModule } from '@angular/material/icon';
import { MatButtonModule } from '@angular/material/button';
import { SidenavService } from '../../../core/services/sidenav/sidenav-service';

@Component({
  selector: 'app-toolbar',
  standalone: true,
  imports: [MatToolbarModule, MatIconModule, MatButtonModule],
  templateUrl: './toolbar.html',
  styleUrl: './toolbar.scss',
})
export class Toolbar implements OnInit {

    constructor(
    private sidenavService: SidenavService,
    private dialog: MatDialog,
    private router: Router
  ) {}

  ngOnInit(): void {
   
  }

  toggleSidenav(): void {
    this.sidenavService.toggle();
  }
}
