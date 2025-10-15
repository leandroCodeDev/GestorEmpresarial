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
import { ClienteService } from '../../core/services/cliente/cliente-service';
import { Dialog } from '../../shared/components/dialog/dialog';
import {CdkAccordionModule} from '@angular/cdk/accordion';
import {MatExpansionModule} from '@angular/material/expansion';
import { ClienteIntefarce } from '../../core/interfaces/cliente/cliente-intefarce';
import { mustMatch } from '../../core/validators/mustMatch.validator';

@Component({
  selector: 'app-cadastro-clientes',
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
  templateUrl: './cadastro-clientes.html',
  styleUrl: './cadastro-clientes.scss'
})
export class CadastroClientes {
  readonly panelOpenState = signal(false);
  clienteData!: ClienteIntefarce
  formCliente!: FormGroup;
  idCliente!: string;
  listaEmpresas:  EmpresaIntefarce[] =[];

  cpfRegex = /^((\d{3}).(\d{3}).(\d{3})-(\d{2}))*$/;


  constructor(
    private activatedRoute: ActivatedRoute,
    private router: Router,
    private clienteService: ClienteService,
    private empresaService: EmpresaService,
    private toastr: ToastrService,
    private dialog: MatDialog,
    private location: Location
  ) {}

  ngOnInit(): void {
    this.idCliente = this.activatedRoute.snapshot.params['id'];

    this.formCliente = new FormGroup({
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
        (this.idCliente)?[
        Validators.minLength(6)
      ]:[
        Validators.required,
        Validators.minLength(6)
      ]),
      confirmSenha: new FormControl('', 
        (this.idCliente)?[]:[Validators.required]),
      documento_path: new FormControl(['', 
        (this.idCliente)?[
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

    if (this.idCliente) {
        this.clienteService.getCliente(this.idCliente).subscribe({
        next: (retorno) => {
            this.clienteData =retorno
            this.clienteData.empresasForm =  this.clienteData.empresas.map((item) => item.id)
            this.formCliente.patchValue(retorno);
            this.formCliente.disable()
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
    this.formCliente.patchValue({ documento_path: file }); // ✅ ok
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
    console.log('chamou',this.formCliente.valid)
    if (this.formCliente.valid) {
      if (this.idCliente) {
        this.editarCliente(this.formCliente.value);
      } else {
        this.cadastrarEmpresa(this.formCliente.value);
      }
    } else {
      this.formCliente.markAllAsTouched();
    }
  }

  habilitarEdicao() {
    this.formCliente.enable();
  }

  cadastrarEmpresa(cliente: ClienteIntefarce) {
    this.clienteService.postCliente(cliente).subscribe({
  next: () => {
    this.toastr.success('Empresa cadastrada com sucesso!');
    this.router.navigate(['/clientes']);
  },
  error: (err) => {
    console.error('Erro ao cadastrar cliente:', err);
    // Aqui você pode tratar mensagens específicas vindas da API
    if (err.status === 400) {
      this.toastr.warning('Dados inválidos! Verifique o formulário.');
    } else if (err.status === 500) {
      this.toastr.error('Erro interno do servidor. Tente novamente mais tarde.');
    } else if (err.status === 422) {
      this.toastr.error('Erro: '+err.error.message);
    }else {
      this.toastr.error('Erro ao cadastrar cliente.');
    }
  }
});
  }

  editarCliente(cliente: ClienteIntefarce) {
    cliente.id = this.idCliente!;
    this.clienteService.putCliente(cliente).subscribe(() => {
      this.toastr.success('Cliente alterado com sucesso!');
      
      if(cliente.documento_path.name){
        console.log('chamou documentos')
        this.clienteService.enviarDocumento(cliente).subscribe()
      }
      
      this.toastr.success('Cliente alterado com sucesso!');
          this.formCliente.disabled
          this.router.navigate(['/clientes']);
    });
  }

  excluirCliente(cliente: ClienteIntefarce){
    cliente.id = this.idCliente!;

    const dialogRef = this.dialog.open(Dialog, {
      data: {
        titulo: 'Excluir Cliente',
        mensagem: 'Você tem certeza que deseja prosseguir com a exclusão?',
        btConfirmar: 'Confirmar',
        btCancelar: 'Cancelar',
      },
    });

    dialogRef.afterClosed().subscribe((retorno) => {
      if (retorno) {
        this.clienteService.deleteDocente(cliente).subscribe(() => {
          this.toastr.success('Empresa excluído com sucesso!');
          this.router.navigate(['/clientes']);
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
