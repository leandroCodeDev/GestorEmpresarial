import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { Subscription } from 'rxjs';
import { FuncionarioIntefarce } from '../../core/interfaces/funcionario/funcionario-intefarce';
import { FuncionarioService } from '../../core/services/funcionario/funcionario-service';

@Component({
  selector: 'app-funcionarios',
  standalone: true,
  imports: [CommonModule, FormsModule, MatIconModule, MatButtonModule],
  templateUrl: './funcionarios.html',
  styleUrl: './funcionarios.scss'
})
export class Funcionarios  implements OnInit{
  private dataSubscription!: Subscription;
  listaFuncionarios: FuncionarioIntefarce[] = [];
  listaFuncionariosFiltradas: FuncionarioIntefarce[] = [];
  textoPesquisa: string | undefined;

  constructor(private funcionarioService: FuncionarioService, private router: Router) {}
  
    ngOnInit(): void {    
      this.funcionarioService.getFuncionarios().subscribe((retorno) => {
        this.listaFuncionarios = retorno
        this.listaFuncionariosFiltradas = this.listaFuncionarios
        console.log(this.listaFuncionariosFiltradas)
      })
    }
      
    verDetalhes(idempresa: string) {
      this.router.navigate(['/funcionarios', idempresa]);
    }
    cadastrar(){
          this.router.navigate(['/funcionarios/cadastro']);
    }
  
    pesquisar() {
      if (this.textoPesquisa) {
        this.funcionarioService.getFuncionarios().subscribe((retorno) => {
          this.listaFuncionariosFiltradas = retorno.filter(
            (empresa) =>
              empresa.nome
                .toUpperCase()
                .includes(this.textoPesquisa!.toUpperCase()) ||
              empresa.endereco.toUpperCase().includes(this.textoPesquisa!.toUpperCase()) ||
              empresa.cpf.toUpperCase().includes(this.textoPesquisa!.toUpperCase())
          );
        });
      } else {
        this.funcionarioService.getFuncionarios().subscribe((retorno) => {
          this.listaFuncionarios = retorno;
          this.listaFuncionariosFiltradas = this.listaFuncionarios
        });
      }
    }
  }
  