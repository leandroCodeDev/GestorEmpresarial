import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';

import { Observable } from 'rxjs';
import { LoadingService } from '../../../core/services/loading/loading-service';

@Component({
  selector: 'app-loading',
  standalone: true,
  imports: [CommonModule, MatProgressSpinnerModule],
  templateUrl: './loading.html',
  styleUrl: './loading.scss',
})
export class Loading {
  loading$: Observable<boolean>;

  constructor(
    private loadingService: LoadingService) {
    this.loading$ = this.loadingService.loading$;
  }
}
