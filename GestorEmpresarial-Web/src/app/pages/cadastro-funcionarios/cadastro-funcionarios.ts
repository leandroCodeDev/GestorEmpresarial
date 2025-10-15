import { ChangeDetectionStrategy, Component, OnInit, signal } from '@angular/core';
import { CommonModule, Location } from '@angular/common';
import {
  AbstractControl,
  FormControl,
  FormGroup,
  ReactiveFormsModule,
  Validators,
} from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { NgLabelTemplateDirective, NgOptionTemplateDirective, NgSelectComponent, NgSelectModule } from '@ng-select/ng-select';
import { ToastrService } from 'ngx-toastr';
import { ToastrModule } from 'ngx-toastr';
import { MatButtonModule } from '@angular/material/button';
import { MatDialog } from '@angular/material/dialog';
import { MatIconModule } from '@angular/material/icon';
import { ErroForm } from '../../shared/components/erro-form/erro-form';
import { EmpresaIntefarce } from '../../core/interfaces/empresa/empresa-intefarce';
import { EmpresaService } from '../../core/services/empresa/empresa-service';
import { FuncionarioService } from '../../core/services/funcionario/funcionario-service';
import { Dialog } from '../../shared/components/dialog/dialog';
import {CdkAccordionModule} from '@angular/cdk/accordion';
import {MatExpansionModule} from '@angular/material/expansion';
import { FuncionarioIntefarce } from '../../core/interfaces/funcionario/funcionario-intefarce';
import { mustMatch } from '../../core/validators/mustMatch.validator';


@Component({
  selector: 'app-cadastro-funcionarios',
    imports: [
     ReactiveFormsModule,
    MatButtonModule,
    MatIconModule,
    NgSelectModule,
    CommonModule,
    ErroForm,
    ToastrModule,
    CdkAccordionModule,
    MatExpansionModule,
    // NgLabelTemplateDirective,
    // NgOptionTemplateDirective,
    NgSelectComponent
  ],
  changeDetection: ChangeDetectionStrategy.OnPush,
  templateUrl: './cadastro-funcionarios.html',
  styleUrl: './cadastro-funcionarios.scss'
})
export class CadastroFuncionarios {
 readonly panelOpenState = signal(false);
  funcionarioData!: FuncionarioIntefarce
  formFuncionario!: FormGroup;
  idFuncionario!: string;
  listaEmpresas:  EmpresaIntefarce[] =[];

  cpfRegex = /^((\d{3}).(\d{3}).(\d{3})-(\d{2}))*$/;
   constructor(
    private activatedRoute: ActivatedRoute,
    private router: Router,
    private funcionarioService: FuncionarioService,
    private empresaService: EmpresaService,
    private toastr: ToastrService,
    private dialog: MatDialog,
    private location: Location
  ) {}

  ngOnInit(): void {
    this.idFuncionario = this.activatedRoute.snapshot.params['id'];

    this.formFuncionario = new FormGroup({
      nome: new FormControl('', [
        Validators.required
      ]),
      cpf: new FormControl('', [
        Validators.required,
        Validators.pattern(this.cpfRegex),
      ]),
      login: new FormControl('', [
        Validators.required
      ]),
      email: new FormControl('', [
        Validators.required
      ]),
      senha: new FormControl('', 
        (this.idFuncionario)?[
        Validators.minLength(6)
      ]:[
        Validators.required,
        Validators.minLength(6)
      ]),
      confirmSenha: new FormControl('', 
        (this.idFuncionario)?[]:[Validators.required]),
      documento_path: new FormControl(['', 
        (this.idFuncionario)?[
        Validators.minLength(6)
        ]:[
        Validators.required,
         this.validarArquivo()
        ]
      ]),
      endereco: new FormControl('', [
        Validators.required
      ]),
      empresasForm: new FormControl([], [
        Validators.required
      ])
    },{
      validators: mustMatch('senha', 'confirmSenha')
    });

  this.empresaService.getEmpresas()
      .subscribe((retorno) => {
        console.log(retorno)
        this.listaEmpresas = retorno
      });

    if (this.idFuncionario) {
        this.funcionarioService.getFuncionario(this.idFuncionario).subscribe({
        next: (retorno) => {
            this.funcionarioData =retorno
            this.funcionarioData.empresasForm =  this.funcionarioData.empresas.map((item) => item.id)
            this.formFuncionario.patchValue(retorno);
            this.formFuncionario.disable()
        },
        error: (erro) => {
          this.toastr.error('Ocorreu um erro ao buscar empresa!');
          console.log(erro);
          this.cancelar()
        },
      });
    }
  }

  onFileChange(event: Event) {
  const input = event.target as HTMLInputElement;
  if (input.files && input.files.length) {
    const file = input.files[0];
    console.log(file)
    this.formFuncionario.patchValue({ documento_path: file }); // ✅ ok
  }
}

validarArquivo() {
    return (control: AbstractControl) => {
      const arquivo = control.value;

      if (!arquivo) return null; // nada selecionado ainda

      const file = arquivo instanceof File ? arquivo : arquivo?.[0];
      if (!file) return null;

      // ✅ valida tipo (por exemplo: só PDF e imagens)
      const tiposPermitidos = ['application/pdf', 'image/jpg'];
      if (!tiposPermitidos.includes(file.type)) {
        return { tipoInvalido: true };
      }

      // ✅ valida tamanho (máximo 2MB)
      const tamanhoMax = 2 * 1024 * 1024; // 2 MB
      if (file.size > tamanhoMax) {
        return { tamanhoExcedido: true };
      }

      return null; // tudo certo
    };
  }


  submitForm() {
    console.log('chamou',this.formFuncionario.valid)
    if (this.formFuncionario.valid) {
      if (this.idFuncionario) {
        this.editarFuncionario(this.formFuncionario.value);
      } else {
        this.cadastrarEmpresa(this.formFuncionario.value);
      }
    } else {
      this.formFuncionario.markAllAsTouched();
    }
  }

  habilitarEdicao() {
    this.formFuncionario.enable();
  }

  cadastrarEmpresa(funcionario: FuncionarioIntefarce) {
    this.funcionarioService.postFuncionario(funcionario).subscribe({
  next: () => {
    this.toastr.success('Empresa cadastrada com sucesso!');
    this.router.navigate(['/funcionarios']);
  },
  error: (err) => {
    console.error('Erro ao cadastrar funcionario:', err);
    // Aqui você pode tratar mensagens específicas vindas da API
    if (err.status === 400) {
      this.toastr.warning('Dados inválidos! Verifique o formulário.');
    } else if (err.status === 500) {
      this.toastr.error('Erro interno do servidor. Tente novamente mais tarde.');
    } else if (err.status === 422) {
      this.toastr.error('Erro: '+err.error.message);
    }else {
      this.toastr.error('Erro ao cadastrar funcionario.');
    }
  }
});
  }

  editarFuncionario(funcionario: FuncionarioIntefarce) {
    funcionario.id = this.idFuncionario!;
    this.funcionarioService.putFuncionario(funcionario).subscribe(() => {
      this.toastr.success('Funcionario alterado com sucesso!');
      
      if(funcionario.documento_path.name){
        console.log('chamou documentos')
        this.funcionarioService.enviarDocumento(funcionario).subscribe()
      }
      
      this.toastr.success('Funcionario alterado com sucesso!');
          this.formFuncionario.disabled
          this.router.navigate(['/funcionarios']);
    });
  }

  excluirFuncionario(funcionario: FuncionarioIntefarce){
    funcionario.id = this.idFuncionario!;

    const dialogRef = this.dialog.open(Dialog, {
      data: {
        titulo: 'Excluir Funcionario',
        mensagem: 'Você tem certeza que deseja prosseguir com a exclusão?',
        btConfirmar: 'Confirmar',
        btCancelar: 'Cancelar',
      },
    });

    dialogRef.afterClosed().subscribe((retorno) => {
      if (retorno) {
        this.funcionarioService.deleteDocente(funcionario).subscribe(() => {
          this.toastr.success('Empresa excluído com sucesso!');
          this.router.navigate(['/funcionarios']);
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


