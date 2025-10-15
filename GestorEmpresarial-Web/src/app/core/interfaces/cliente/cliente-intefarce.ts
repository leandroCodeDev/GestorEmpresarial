import { EmpresaIntefarce } from "../empresa/empresa-intefarce";

export interface ClienteIntefarce {
    id:string,
    nome:string,
    login:string,
    cpf:string,
    email:string,
    endereco:string,
    documento:string,
    empresas:EmpresaIntefarce[]
}
