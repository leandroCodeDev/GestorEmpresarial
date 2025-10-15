import { CommonModule } from '@angular/common';
import {
  Component,
  Inject,
  Output,
  EventEmitter,
  ChangeDetectionStrategy,
} from '@angular/core';
import { MatButtonModule } from '@angular/material/button';
import {
  MatDialogRef,
  MAT_DIALOG_DATA,
  MatDialogContent,
  MatDialogTitle,
  MatDialogActions,
} from '@angular/material/dialog';
import { MatIconModule } from '@angular/material/icon';

@Component({
  selector: 'app-dialog',
  standalone: true,
  imports: [
    MatDialogTitle,
    MatDialogContent,
    MatDialogActions,
    MatButtonModule,
    MatIconModule,
    CommonModule,
  ],
  templateUrl: './dialog.html',
  styleUrl: './dialog.scss',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class Dialog {
  titulo!: string;
  mensagem!: string;
  btConfirmar!: string;
  btCancelar!: string;

  @Output() confirmar = new EventEmitter<void>();
  @Output() cancelar = new EventEmitter<void>();

  constructor(
    public dialogRef: MatDialogRef<Dialog>,
    @Inject(MAT_DIALOG_DATA) public data: any
  ) {
    if (data) {
      this.titulo = data.titulo;
      this.mensagem = data.mensagem;
      this.btConfirmar = data.btConfirmar;
      this.btCancelar = data.btCancelar;
    }
  }

  confirmarAcao(): void {
    this.confirmar.emit();
    this.dialogRef.close(true);
  }

  cancelarAcao(): void {
    this.cancelar.emit();
    this.dialogRef.close(false);
  }
}
