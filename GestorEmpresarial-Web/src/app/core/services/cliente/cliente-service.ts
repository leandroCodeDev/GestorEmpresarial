import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ClienteIntefarce } from '../../interfaces/cliente/cliente-intefarce';



@Injectable({
  providedIn: 'root'
})
export class ClienteService {
   url = 'http://localhost:8989/api/clientes';

  constructor(private httpClient: HttpClient) {}

  getClientes() {
    return this.httpClient.get<Array<ClienteIntefarce>>(this.url);
  }

  getCliente(id: string) {
    return this.httpClient.get<ClienteIntefarce>(this.url + `/${id}`);
  }


  postCliente(cliente: ClienteIntefarce) {
    const formData = new FormData();
    formData.append('nome', cliente.nome);
    formData.append('login', cliente.login);
    formData.append('senha', cliente.senha);
    formData.append('cpf', cliente.cpf);
    formData.append('email', cliente.email);
    formData.append('endereco', cliente.endereco);
    formData.append('documento', cliente.documento_path);

    cliente.empresasForm.forEach((func: any, index: number) => {
      formData.append(`empresas[${index}]`, func);
    });
    return this.httpClient.post<any>(this.url, formData);
  }

  putCliente(cliente: ClienteIntefarce) {
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
    form.nome = cliente.nome
    form.login = cliente.login
    form.senha = cliente.senha
    form.cpf = cliente.cpf
    form.email = cliente.email
    form.endereco = cliente.endereco
    form.empresas = cliente.empresasForm

    
    return this.httpClient.put<any>(this.url + `/${cliente.id}`, form);
  }

  enviarDocumento(cliente: ClienteIntefarce) {
    const formData = new FormData();
    formData.append('documento', cliente.documento_path);
    
    return this.httpClient.post<any>(this.url + `/${cliente.id}/documento`, formData);
  }

  deleteDocente(Cliente: ClienteIntefarce) {
    return this.httpClient.delete<any>(this.url + `/${Cliente.id}`);
  }
}

