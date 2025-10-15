import { ChangeDetectionStrategy, Component, OnInit, signal } from '@angular/core';
import { CommonModule, Location } from '@angular/common';
import {
  FormControl,
  FormGroup,
  ReactiveFormsModule,
  Validators,
} from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { NgSelectModule } from '@ng-select/ng-select';
import { ToastrService } from 'ngx-toastr';
import { ToastrModule } from 'ngx-toastr';
import { MatButtonModule } from '@angular/material/button';
import { MatDialog } from '@angular/material/dialog';
import { MatIconModule } from '@angular/material/icon';
import { ErroForm } from '../../shared/components/erro-form/erro-form';
import { EmpresaIntefarce } from '../../core/interfaces/empresa/empresa-intefarce';
import { EmpresaService } from '../../core/services/empresa/empresa-service';
import { FuncionarioService } from '../../core/services/funcionario/funcionario-service';
import { ClienteService } from '../../core/services/cliente/cliente-service';
import { Dialog } from '../../shared/components/dialog/dialog';
import {CdkAccordionModule} from '@angular/cdk/accordion';
import {MatExpansionModule} from '@angular/material/expansion';


@Component({
  selector: 'app-cadastro-empresas',
  imports: [
     ReactiveFormsModule,
    MatButtonModule,
    MatIconModule,
    NgSelectModule,
    CommonModule,
    ErroForm,
    ToastrModule,
    CdkAccordionModule,
    MatExpansionModule
  ],
  changeDetection: ChangeDetectionStrategy.OnPush,
  templateUrl: './cadastro-empresas.html',
  styleUrl: './cadastro-empresas.scss'
})
export class CadastroEmpresas {
  readonly panelOpenState = signal(false);
  empresaData!: EmpresaIntefarce
  formEmpresa!: FormGroup;
  idEmpresa!: string;

  cnpjRegex = /^((\d{2}).(\d{3}).(\d{3})\/(\d{4})-(\d{2}))*$/;


  constructor(
    private activatedRoute: ActivatedRoute,
    private router: Router,
    private empresaService: EmpresaService,
    private toastr: ToastrService,
    private dialog: MatDialog,
    private location: Location
  ) {}

  ngOnInit(): void {
    this.idEmpresa = this.activatedRoute.snapshot.params['id'];

    this.formEmpresa = new FormGroup({
      nome: new FormControl('', [
        Validators.required
      ]),
      cnpj: new FormControl('', [
        Validators.required,
        Validators.pattern(this.cnpjRegex),
      ]),
      endereco: new FormControl('', [
        Validators.required
      ]),
    });



    if (this.idEmpresa) {
        this.empresaService.getEmpresa(this.idEmpresa).subscribe({
        next: (retorno) => {
            this.empresaData =retorno
            console.log(this.empresaData.clientes)
            this.formEmpresa.patchValue(retorno);
            this.formEmpresa.disable()
        },
        error: (erro) => {
          this.toastr.error('Ocorreu um erro ao buscar empresa!');
          console.log(erro);
          this.cancelar()
        },
      });
    }
  }



  submitForm() {
    if (this.formEmpresa.valid) {
      if (this.idEmpresa) {
        this.editarEmpresa(this.formEmpresa.value);
      } else {
        this.cadastrarEmpresa(this.formEmpresa.value);
      }
    } else {
      this.formEmpresa.markAllAsTouched();
    }
  }

  habilitarEdicao() {
    this.formEmpresa.enable();
  }

  cadastrarEmpresa(empresa: EmpresaIntefarce) {
    this.empresaService.postEmpresa(empresa).subscribe({
  next: () => {
    this.toastr.success('Empresa cadastrada com sucesso!');
    this.router.navigate(['/home']);
  },
  error: (err) => {
    console.error('Erro ao cadastrar empresa:', err);
    // Aqui você pode tratar mensagens específicas vindas da API
    if (err.status === 400) {
      this.toastr.warning('Dados inválidos! Verifique o formulário.');
    } else if (err.status === 500) {
      this.toastr.error('Erro interno do servidor. Tente novamente mais tarde.');
    } else if (err.status === 422) {
      this.toastr.error('Erro: '+err.error.message);
    }else {
      this.toastr.error('Erro ao cadastrar empresa.');
    }
  }
});
  }

  editarEmpresa(empresa: EmpresaIntefarce) {
    empresa.id = this.idEmpresa!;
    this.empresaService.putEmpresa(empresa).subscribe(() => {
      this.toastr.success('Empresa alterado com sucesso!');

      this.formEmpresa.disabled
      this.router.navigate(['/empresas']);
    });
  }

  excluirEmpresa(empresa: EmpresaIntefarce){
    empresa.id = this.idEmpresa!;

    const dialogRef = this.dialog.open(Dialog, {
      data: {
        titulo: 'Excluir Empresa',
        mensagem: 'Você tem certeza que deseja prosseguir com a exclusão?',
        btConfirmar: 'Confirmar',
        btCancelar: 'Cancelar',
      },
    });

    dialogRef.afterClosed().subscribe((retorno) => {
      if (retorno) {
        this.empresaService.deleteDocente(empresa).subscribe(() => {
          this.toastr.success('Empresa excluído com sucesso!');
          this.router.navigate(['/home']);
        });
      } else {
        return;
      }
    });
  }

  cancelar() {
    this.location.back();
  }
}
