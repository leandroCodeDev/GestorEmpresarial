import { EmpresaIntefarce } from "../empresa/empresa-intefarce";

export interface FuncionarioIntefarce {
    id:string,
    nome:string,
    login:string,
    cpf:string,
    email:string,
    endereco:string,
    documento_path:File,
    documento:string,
    empresas:EmpresaIntefarce[]
}
