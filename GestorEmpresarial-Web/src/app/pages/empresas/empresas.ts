import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { EmpresaService } from '../../core/services/empresa/empresa-service';
import { EmpresaIntefarce } from '../../core/interfaces/empresa/empresa-intefarce';
import { Subscription } from 'rxjs';




@Component({
  selector: 'app-empresas',
 standalone: true,
  imports: [CommonModule, FormsModule, MatIconModule, MatButtonModule],
  templateUrl: './empresas.html',
  styleUrl: './empresas.scss'
})
export class Empresas implements OnInit{

  private dataSubscription!: Subscription;
  listaEmpresas: EmpresaIntefarce[] = [];
  listaEmpresasFiltradas: EmpresaIntefarce[] = [];
  textoPesquisa: string | undefined;

  constructor(private empresaService: EmpresaService, private router: Router) {}

  ngOnInit(): void {    
    this.empresaService.getEmpresas().subscribe((retorno) => {
      this.listaEmpresas = retorno
      this.listaEmpresasFiltradas = this.listaEmpresas
      console.log(this.listaEmpresasFiltradas)
    })
  }
    
  verDetalhes(idempresa: string) {
    this.router.navigate(['/empresas', idempresa]);
  }
  cadastrar(){
        this.router.navigate(['/empresas/cadastro']);
  }

  pesquisar() {
    if (this.textoPesquisa) {
      this.empresaService.getEmpresas().subscribe((retorno) => {
        this.listaEmpresasFiltradas = retorno.filter(
          (empresa) =>
            empresa.nome
              .toUpperCase()
              .includes(this.textoPesquisa!.toUpperCase()) ||
            empresa.endereco.toUpperCase().includes(this.textoPesquisa!.toUpperCase()) ||
            empresa.cnpj.toUpperCase().includes(this.textoPesquisa!.toUpperCase())
        );
      });
    } else {
      this.empresaService.getEmpresas().subscribe((retorno) => {
        this.listaEmpresas = retorno;
        this.listaEmpresasFiltradas = this.listaEmpresas
      });
    }
  }
}
