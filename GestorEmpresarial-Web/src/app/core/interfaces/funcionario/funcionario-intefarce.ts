import { EmpresaIntefarce } from "../empresa/empresa-intefarce";

export interface FuncionarioIntefarce {
  id:string,
    nome:string,
    login:string,
    senha:string
    confirmSenha:string
    cpf:string,
    email:string,
    endereco:string,
    documento:string,
    documento_path:File,
    empresasForm:any[]
    empresas:EmpresaIntefarce[]
}