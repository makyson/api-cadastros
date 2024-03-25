<?php

namespace Util;


abstract class ConstantesGenericasUtil
{
    /* REQUESTS */
    public const TIPO_REQUEST = ['GET', 'POST', 'DELETE', 'PUT'];
    public const TIPO_GET = ['MOTORISTA', 'MOTORISTAS', 'VEICULO', 'VEICULOS', 'TRANSPORTADORA', 'TRANSPORTADORAS', 'CLIENTES', 'CLIENTE'];// ajustei mais rotas veiculos e motoristas
    public const TIPO_POST = ['MOTORISTA', 'VEICULO', 'TRANSPORTADORA', 'CLIENTE'];
    public const TIPO_DELETE = ['MOTORISTA', 'VEICULO', 'TRANSPORTADORA', 'CLIENTE'];
    public const TIPO_PUT = ['MOTORISTA', 'VEICULO', 'TRANSPORTADORA', 'CLIENTE'];


    //public const NumeroBot = '+55 99 91853509';
    public const NumeroBot = '+55 99 92330128';



    /*  pipefy estrutura e config  */

    // = >  id: "placa_do_cavalo_mec_nico_1",	label: "Placa do Cavalo Mecânico"	id: "copy_of_placa_do_cavalo_mec_nico_1",	label: "Placa da Carreta"	id: "tipo_ve_culo",	label: "Tipo Veículo"	id: "s",	label: "ANTT"
    public const EstruraVeiculo = ['placa_do_cavalo_mec_nico_1', 'copy_of_placa_do_cavalo_mec_nico_1', 'tipo_ve_culo', 's'];
    public const PipeVeiculo  = "304023091" ;
    public const FaseVeiculoinicio  = "324824268" ;

    // = >   id: "nome",	label: "Nome"	id: "numero_de_telefone",	label: "Numero de Telefone"	id: "cpf",	label: "CPF"	id: "n",	label: "N° CNH"	id: "n_cnh",	label: "Cidade"	id: "copy_of_cidade",	label: "Estado"	id: "copy_of_estado",	label: "Endereço"
    public const EstruraMotorista = ['nome', 'numero_de_telefone', 'cpf', 'n', 'n_cnh','copy_of_cidade','copy_of_estado'];
    public const PipeMotorista  = "304023081";
    public const FaseMotoristainicio  = "324431499";
    
    // = >  id: "nome_do_transportador",	label: "Nome do Transportador"	id: "n_mero_de_telefone",	label: "Número de telefone"	id: "cnpj",	label: "CNPJ"	id: "inscri_ao_estadual",	label: "Inscriçao Estadual"	id: "cidade",	label: "Cidade"	id: "copy_of_cidade",	label: "Estado"	id: "copy_of_estado",	label: "Endereço"	id: "antt",	label: "ANTT"	id: "email",	label: "Email"	id: "respons_vel",	label: "Responsável"	
    public const EstruraTransportadora = ['nome_do_transportador', 'n_mero_de_telefone', 'cnpj', 'inscri_ao_estadual', 'cidade', 'copy_of_cidade', 'copy_of_estado', 'antt', 'email', 'respons_vel'];
    public const PipeTransportadora  = "304014312";
    public const FaseTransportadorainicio  = "324381074";


    /* ERROS */
    public const MSG_ERRO_TIPO_ROTA = 'Rota não permitida!';
    public const MSG_ERRO_RECURSO_INEXISTENTE = 'Recurso inexistente!';
    public const MSG_ERRO_GENERICO = 'Algum erro ocorreu na requisição!';
    public const MSG_ERRO_SEM_RETORNO = 'Nenhum registro encontrado!';
    public const MSG_ERRO_NAO_AFETADO = 'Nenhum registro afetado!';
    public const MSG_ERRO_TOKEN_VAZIO = 'É necessário informar um Token!';
    public const MSG_ERRO_TOKEN_NAO_AUTORIZADO = 'Token não autorizado!';
    public const MSG_ERR0_JSON_VAZIO = 'O Corpo da requisição não pode ser vazio!';

    public const MSG_PIPEFY_CPF_EXISTE = 'Ops! Parece que este CPF já está associado a uma conta. #code:';

    /* SUCESSO */
    public const MSG_DELETADO_SUCESSO = 'Registro deletado com Sucesso!';
    public const MSG_ATUALIZADO_SUCESSO = 'Registro atualizado com Sucesso!';

    /* RECURSO MOTORISTAS */
    public const MSG_ERRO_ID_OBRIGATORIO = 'ID é obrigatório!';
    public const MSG_ERRO_LOGIN_EXISTENTE = 'Login já existente!';
    public const MSG_ERRO_LOGIN_SENHA_OBRIGATORIO = 'Login e Senha são obrigatórios!';
    public const MSG_ERRO_PLACAS_OBRIGATORIO = 'Placas são obrigatórios!';

     public const MSG_ERRO_SERVICO_TERCERIZADO_ERRO = 'Enfrentamos um contratempo em um de nossos serviços.';


    public const MSG_ERRO_CNPJ_OBRIGATORIO = 'CNPJ são obrigatórios!';

    /* RETORNO JSON */
    const TIPO_SUCESSO = 'sucesso';
    const TIPO_ERRO = 'erro';

    /* OUTRAS */
    public const SIM = 'S';
    public const TIPO = 'tipo';
    public const RESPOSTA = 'resposta';
}