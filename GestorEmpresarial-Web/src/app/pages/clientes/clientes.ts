import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { Subscription } from 'rxjs';
import { ClienteIntefarce } from '../../core/interfaces/cliente/cliente-intefarce';
import { ClienteService } from '../../core/services/cliente/cliente-service';

@Component({
  selector: 'app-clientes',
   standalone: true,
  imports: [CommonModule, FormsModule, MatIconModule, MatButtonModule],
  templateUrl: './clientes.html',
  styleUrl: './clientes.scss'
})
export class Clientes  implements OnInit{
private dataSubscription!: Subscription;
  listaClientes: ClienteIntefarce[] = [];
  listaClientesFiltradas: ClienteIntefarce[] = [];
  textoPesquisa: string | undefined;

  constructor(private clienteService: ClienteService, private router: Router) {}

  ngOnInit(): void {    
    this.clienteService.getClientes().subscribe((retorno) => {
      this.listaClientes = retorno
      this.listaClientesFiltradas = this.listaClientes
      console.log(this.listaClientesFiltradas)
    })
  }
    
  verDetalhes(idempresa: string) {
    this.router.navigate(['/clientes', idempresa]);
  }
  cadastrar(){
        this.router.navigate(['/clientes/cadastro']);
  }

  pesquisar() {
    if (this.textoPesquisa) {
      this.clienteService.getClientes().subscribe((retorno) => {
        this.listaClientesFiltradas = retorno.filter(
          (empresa) =>
            empresa.nome
              .toUpperCase()
              .includes(this.textoPesquisa!.toUpperCase()) ||
            empresa.endereco.toUpperCase().includes(this.textoPesquisa!.toUpperCase()) ||
            empresa.cpf.toUpperCase().includes(this.textoPesquisa!.toUpperCase())
        );
      });
    } else {
      this.clienteService.getClientes().subscribe((retorno) => {
        this.listaClientes = retorno;
        this.listaClientesFiltradas = this.listaClientes
      });
    }
  }
}
