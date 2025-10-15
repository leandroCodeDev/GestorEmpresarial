import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { FuncionarioIntefarce } from '../../interfaces/funcionario/funcionario-intefarce';



@Injectable({
  providedIn: 'root'
})
export class FuncionarioService {
   url = 'http://localhost:8989/api/funcionarios';

  constructor(private httpClient: HttpClient) {}

  getFuncionarios() {
    return this.httpClient.get<Array<FuncionarioIntefarce>>(this.url);
  }

  getFuncionario(id: string) {
    return this.httpClient.get<FuncionarioIntefarce>(this.url + `/${id}`);
  }


  postFuncionario(funcionario: FuncionarioIntefarce) {
    const formData = new FormData();
    formData.append('nome', funcionario.nome);
    formData.append('login', funcionario.login);
    formData.append('senha', funcionario.senha);
    formData.append('cpf', funcionario.cpf);
    formData.append('email', funcionario.email);
    formData.append('endereco', funcionario.endereco);
    formData.append('documento', funcionario.documento_path);

    funcionario.empresasForm.forEach((func: any, index: number) => {
      formData.append(`empresas[${index}]`, func);
    });
    return this.httpClient.post<any>(this.url, formData);
  }

  putFuncionario(funcionario: FuncionarioIntefarce) {
    interface Empresa {
  
  }
     const form: {
    nome: string;
    login: string;
    senha: string;
    cpf: string;
    email: string;
    endereco: string;
    empresas: number[];
  } = {
    nome: '',
    login: '',
    senha: '',
    cpf: '',
    email: '',
    endereco: '',
    empresas: []
  };
    form.nome = funcionario.nome
    form.login = funcionario.login
    form.senha = funcionario.senha
    form.cpf = funcionario.cpf
    form.email = funcionario.email
    form.endereco = funcionario.endereco
    form.empresas = funcionario.empresasForm

    
    return this.httpClient.put<any>(this.url + `/${funcionario.id}`, form);
  }

  enviarDocumento(funcionario: FuncionarioIntefarce) {
    const formData = new FormData();
    formData.append('documento', funcionario.documento_path);
    
    return this.httpClient.post<any>(this.url + `/${funcionario.id}/documento`, formData);
  }

  deleteDocente(Funcionario: FuncionarioIntefarce) {
    return this.httpClient.delete<any>(this.url + `/${Funcionario.id}`);
  }
}

