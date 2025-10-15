import { ClienteIntefarce } from "../cliente/cliente-intefarce"
import { FuncionarioIntefarce } from "../funcionario/funcionario-intefarce"

export interface EmpresaIntefarce {
id:string
nome:string
cnpj:string
endereco:string
clientes:ClienteIntefarce[]
funcionarios:FuncionarioIntefarce[]
}
