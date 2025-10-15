import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { EmpresaIntefarce } from '../../interfaces/empresa/empresa-intefarce';
import { Empresas } from '../../../pages/empresas/empresas';


@Injectable({
  providedIn: 'root'
})
export class EmpresaService {
   url = 'http://localhost:8989/api/empresas';

  constructor(private httpClient: HttpClient) {}

  getEmpresas() {
    return this.httpClient.get<Array<EmpresaIntefarce>>(this.url);
  }

  getEmpresa(id: string) {
    return this.httpClient.get<EmpresaIntefarce>(this.url + `/${id}`);
  }


  postEmpresa(empresa: EmpresaIntefarce) {
    return this.httpClient.post<any>(this.url, empresa);
  }

  putEmpresa(empresa: EmpresaIntefarce) {
    return this.httpClient.put<any>(this.url + `/${empresa.id}`, empresa);
  }

  deleteDocente(empresa: EmpresaIntefarce) {
    return this.httpClient.delete<any>(this.url + `/${empresa.id}`);
  }
}

