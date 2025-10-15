import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ClienteIntefarce } from '../../interfaces/cliente/cliente-intefarce';



@Injectable({
  providedIn: 'root'
})
export class ClienteService {
   url = 'http://localhost:8989/api/Clientes';

  constructor(private httpClient: HttpClient) {}

  getClientes() {
    return this.httpClient.get<Array<ClienteIntefarce>>(this.url);
  }

  getCliente(id: string) {
    return this.httpClient.get<ClienteIntefarce>(this.url + `/${id}`);
  }


  postCliente(Cliente: ClienteIntefarce) {
    return this.httpClient.post<any>(this.url, Cliente);
  }

  putCliente(Cliente: ClienteIntefarce) {
    return this.httpClient.put<any>(this.url + `/${Cliente.id}`, Cliente);
  }

  deleteDocente(Cliente: ClienteIntefarce) {
    return this.httpClient.delete<any>(this.url + `/${Cliente.id}`);
  }
}

