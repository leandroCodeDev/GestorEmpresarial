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
    return this.httpClient.post<any>(this.url, funcionario);
  }

  putFuncionario(funcionario: FuncionarioIntefarce) {
    return this.httpClient.put<any>(this.url + `/${funcionario.id}`, funcionario);
  }

  deleteDocente(funcionario: FuncionarioIntefarce) {
    return this.httpClient.delete<any>(this.url + `/${funcionario.id}`);
  }
}

