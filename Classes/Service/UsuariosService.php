<?php


namespace Service;

use InvalidArgumentException;
use Repository\UsuariosRepository;
use Util\ConstantesGenericasUtil;

use Service\PipefyApi;














class UsuariosService{

    public const TABELA = 'motoristas';
    public const RECURSOS_GET = ['listar', 'listarpordata'];
    public const RECURSOS_DELETE = ['delete'];
    public const RECURSOS_POST = ['cadastrar'];
    public const RECURSOS_PUT = ['atualizar'];

    private array $dados;

    private array $dadosCorpoRequest = [];

    private object $UsuariosRepository;

    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->UsuariosRepository = new UsuariosRepository();
    }

    public function validarGet()
    {

        $retorno = null;
        $recurso = $this->dados['recurso'];

        if (in_array($recurso, self::RECURSOS_GET, true)) {

            $retorno = $this->dados['id'] > 0 ? $this->getOneByKey() : $this->$recurso();
            
        }else{
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            
        }

        if ($retorno === null) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

        return $retorno;


    }
    
    public function getOneByKey() {

        $tabela = $this->dados['rotas']."s";

        //Trecho inserido para ajustar para a tabela de tclientes
        if (strtolower($this->dados['rotas']) == 'cliente') {
            $tabela = "t".$this->dados['rotas']."s";
        }

        return $this->UsuariosRepository->getMySql()->getOneByKey($tabela, $this->dados['id'], $this->dados['rotas']);
        
    }

    public function listar(){

        if (strtolower($this->dados['rotas']) == 'clientes') {//Ajuste para a rota ficar com o nome da tabela de tclientes
            $this->dados['rotas'] = "t".$this->dados['rotas'];
        }

        return $this->UsuariosRepository->getMySql()->getAll($this->dados['rotas']);//alterei o parametro do getAll para dados rotas ao invés da const TABELA

    }

    public function validarDelete()
    {

        $retorno = null;
        $recurso = $this->dados['recurso'];

        if (in_array($recurso, self::RECURSOS_DELETE, true)) {

            if($this->dados['id'] > 0){

                $retorno = $this->$recurso();

            }else{
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_ID_OBRIGATORIO);
            }
            
        }else{
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            
        }

        if ($retorno === null) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

        return $retorno;


    }

    public function delete(){

        $tabela = $this->dados['rotas']."s";

        //Trecho inserido para ajustar para a tabela de tclientes
        if (strtolower($this->dados['rotas']) == 'cliente') {
            $tabela = "t".$this->dados['rotas']."s";
        }

        return $this->UsuariosRepository->getMySql()->delete($tabela, $this->dados['id'], $this->dados['rotas']);

    }

    public function setDadosCorpoRequest($dadosRequest) {

        $this->dadosCorpoRequest = $dadosRequest;

    }

    public function validarPost()
    {

        $retorno = null;
        $recurso = $this->dados['recurso'];

        if (in_array($recurso, self::RECURSOS_POST, true)) {

            $retorno = $this->$recurso();
            
        }else{
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            
        }

        if ($retorno == null) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

        return $retorno;


    }

    public function validarPut()
    {

        $retorno = null;
        $recurso = $this->dados['recurso'];

        if (in_array($recurso, self::RECURSOS_PUT, true)) {

            if($this->dados['id'] > 0){

                $retorno = $this->$recurso();

            }else{
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_ID_OBRIGATORIO);
            }
            
        }else{
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            
        }

        if ($retorno === null) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

        return $retorno;


    }

    public function cadastrar(){

        //Cadastro Motorista
        if (!empty($this->dados['rotas']) && strtolower($this->dados['rotas']) == 'motorista') {
            
                //var_dump($this->dadosCorpoRequest);
                [$nome, $cnh, $cpf, $telefone, $cidade, $estado, $endereco, $ativo] = [$this->dadosCorpoRequest['NomeMotorista'], $this->dadosCorpoRequest['Cnh'], $this->dadosCorpoRequest['Cpf'], $this->dadosCorpoRequest['Telefone'], $this->dadosCorpoRequest['Cidade'], $this->dadosCorpoRequest['Estado'], $this->dadosCorpoRequest['Endereco'], $this->dadosCorpoRequest['Ativo']];

                if($nome && $cnh && $cpf){

                    $pipecodecard =  PipefyApi::CreateCardWithFields(
                        id_pipe:ConstantesGenericasUtil::PipeMotorista,
                        id_grupo:ConstantesGenericasUtil::FaseMotoristainicio,
                        campo:ConstantesGenericasUtil::EstruraMotorista,
                  
                        value:[
                         
                            $nome, 
                            $telefone,
                            $cpf, 
                            $cnh,
                            $cidade, 
                            $estado, 
                            $endereco,
                            
                            
    
                        ]
                        );
    




                    //var_dump([$login, $senha, $empresa]);
                    if($this->UsuariosRepository->insertUser($nome, $cnh, $cpf, $telefone, $cidade, $estado, $endereco,$pipecodecard, $ativo) > 0){
    
                        $idInserido = $this->UsuariosRepository->getMySQL()->getDb()->lastInsertId();
                        $this->UsuariosRepository->getMySQL()->getDb()->commit();
    
                        return ['id_Inserido' => $idInserido];
    
                    }
    
                    $this->UsuariosRepository->getMySQL()->getDb()->rollBack();
    
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO.' função cadastrar UsuarioService!');
    
                }else{
    
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_LOGIN_SENHA_OBRIGATORIO);
                }
        //Cadastro Veiculo
        }elseif(!empty($this->dados['rotas']) && strtolower($this->dados['rotas']) == 'veiculo'){



       //var_dump($this->dadosCorpoRequest);
       [$cavalo, $carreta, $tipo, $antt,$pipecodecard, $ativo] = [$this->dadosCorpoRequest['PlacaCavalo'], $this->dadosCorpoRequest['PlacaCarreta'], $this->dadosCorpoRequest['Tipo'], $this->dadosCorpoRequest['Antt'], $this->dadosCorpoRequest['Ativo'],$this->dadosCorpoRequest['PipeCodeCard']];

       

           if($cavalo){

  
                
            $pipecodecard =  PipefyApi::CreateCardWithFields(
                id_pipe:ConstantesGenericasUtil::PipeVeiculo,
                id_grupo:ConstantesGenericasUtil::FaseVeiculoinicio,
                campo:ConstantesGenericasUtil::EstruraVeiculo,
                value:[
                    $cavalo,
                    $carreta, 
                    $tipo, 
                    $antt
                ]
                );
                
                //var_dump([$login, $senha, $empresa]);
                if($this->UsuariosRepository->insertVeiculo($cavalo, $carreta, $tipo, $antt,$pipecodecard, $ativo) > 0){


                           
        
             
           
                        


               

                    $idInserido = $this->UsuariosRepository->getMySQL()->getDb()->lastInsertId();
                    $this->UsuariosRepository->getMySQL()->getDb()->commit();

                    return ['id_Inserido' => $idInserido];

                }

                $this->UsuariosRepository->getMySQL()->getDb()->rollBack();

                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO.' função cadastrar UsuarioService!');

            }else{

                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_PLACAS_OBRIGATORIO);
            }
        //Cadastro Transportadora
        }elseif(!empty($this->dados['rotas']) && strtolower($this->dados['rotas']) == 'transportadora'){

            //var_dump($this->dadosCorpoRequest);
            [$nome, $telefone, $cnpj, $email, $incricaoEstadual, $cidade, $estado, $endereco, $responsavel,$antt, $ativo] = [$this->dadosCorpoRequest['Nome'], $this->dadosCorpoRequest['Telefone'], $this->dadosCorpoRequest['Cnpj'], $this->dadosCorpoRequest['Email'], $this->dadosCorpoRequest['IncricaoEstadual'], $this->dadosCorpoRequest['Cidade'], $this->dadosCorpoRequest['Estado'], $this->dadosCorpoRequest['Endereco'], $this->dadosCorpoRequest['Responsavel'],$this->dadosCorpoRequest['Antt'],  $this->dadosCorpoRequest['Ativo']];

            if($cnpj){


                $pipecodecard =  PipefyApi::CreateCardWithFields(
                    id_pipe:ConstantesGenericasUtil::PipeTransportadora,
                    id_grupo:ConstantesGenericasUtil::FaseTransportadorainicio,
                    campo:ConstantesGenericasUtil::EstruraTransportadora,
                    value:[
                     
                        $nome,
                          
                        $telefone, 
                        $cnpj,
                        $incricaoEstadual, 
                        $cidade, 
                        $estado, 
                        $endereco,
                        $antt,
                        $email,  
                        $responsavel 
                        
                        

                    ]
                    );



                //var_dump([$login, $senha, $empresa]);
                if($this->UsuariosRepository->insertTransportadora($nome, $telefone, $cnpj, $email, $incricaoEstadual, $cidade, $estado, $endereco, $responsavel,$antt,$pipecodecard, $ativo) > 0){

                    $idInserido = $this->UsuariosRepository->getMySQL()->getDb()->lastInsertId();
                    $this->UsuariosRepository->getMySQL()->getDb()->commit();

                    return ['id_Inserido' => $idInserido];

                }

                $this->UsuariosRepository->getMySQL()->getDb()->rollBack();

                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO.' função cadastrar UsuarioService!');

            }else{

                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_CNPJ_OBRIGATORIO);
            }

        }elseif(!empty($this->dados['rotas']) && strtolower($this->dados['rotas']) == 'cliente'){

            //var_dump($this->dadosCorpoRequest);
            [$nome, $endereco, $bairro, $cep, $cidade, $uf, $ddd, $telefone, $cnpj, $email, $empresa, $coordenada] = [$this->dadosCorpoRequest['NomeCliente'], $this->dadosCorpoRequest['EnderecoCliente'], $this->dadosCorpoRequest['BairroCliente'], $this->dadosCorpoRequest['CepCliente'], $this->dadosCorpoRequest['CidadeCliente'], $this->dadosCorpoRequest['UFCliente'], $this->dadosCorpoRequest['DDDCliente'], $this->dadosCorpoRequest['FoneCliente'], $this->dadosCorpoRequest['CNPJCliente'], $this->dadosCorpoRequest['EmailCliente'], $this->dadosCorpoRequest['CodEmpresa'], $this->dadosCorpoRequest['CoordenadaCliente']];

            if($cnpj){
                //var_dump([$login, $senha, $empresa]);
                if($this->UsuariosRepository->insertCliente($nome, $endereco, $bairro, $cep, $cidade, $uf, $ddd, $telefone, $cnpj, $email, $empresa, $coordenada) > 0){

                    $idInserido = $this->UsuariosRepository->getMySQL()->getDb()->lastInsertId();
                    $this->UsuariosRepository->getMySQL()->getDb()->commit();

                    return ['id_Inserido' => $idInserido];

                }

                $this->UsuariosRepository->getMySQL()->getDb()->rollBack();

                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO.' função cadastrar UsuarioService!');

            }else{

                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_CNPJ_OBRIGATORIO);
            }

        }else{
    
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_LOGIN_SENHA_OBRIGATORIO." ".var_dump($this->dados['rotas']));
        }

    }

    public function atualizar()
    {

        if (!empty($this->dados['rotas']) && strtolower($this->dados['rotas']) == 'motorista') {

            if ($this->UsuariosRepository->updateUser($this->dados['id'], $this->dadosCorpoRequest) > 0) {
                $this->UsuariosRepository->getMySQL()->getDb()->commit();
    
                var_dump($this->dadosCorpoRequest);
                
                return ConstantesGenericasUtil::MSG_ATUALIZADO_SUCESSO;
            }else {
                $this->UsuariosRepository->getMySQL()->getDb()->rollBack();
    
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_NAO_AFETADO);
            }
        }elseif (!empty($this->dados['rotas']) && strtolower($this->dados['rotas']) == 'veiculo') {
            
            if ($this->UsuariosRepository->updateVeiculo($this->dados['id'], $this->dadosCorpoRequest) > 0) {
                $this->UsuariosRepository->getMySQL()->getDb()->commit();
    
                var_dump($this->dadosCorpoRequest);
                
                return ConstantesGenericasUtil::MSG_ATUALIZADO_SUCESSO;
            }else {
                $this->UsuariosRepository->getMySQL()->getDb()->rollBack();
    
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_NAO_AFETADO);
            }
        }elseif (!empty($this->dados['rotas']) && strtolower($this->dados['rotas']) == 'transportadora') {
            
            if ($this->UsuariosRepository->updateTransportadora($this->dados['id'], $this->dadosCorpoRequest) > 0) {
                $this->UsuariosRepository->getMySQL()->getDb()->commit();
    
                var_dump($this->dadosCorpoRequest);
                
                return ConstantesGenericasUtil::MSG_ATUALIZADO_SUCESSO;
            }else {
                $this->UsuariosRepository->getMySQL()->getDb()->rollBack();
    
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_NAO_AFETADO);
            }
        }elseif (!empty($this->dados['rotas']) && strtolower($this->dados['rotas']) == 'cliente') {
            
            if ($this->UsuariosRepository->updateCliente($this->dados['id'], $this->dadosCorpoRequest) > 0) {
                $this->UsuariosRepository->getMySQL()->getDb()->commit();
    
                var_dump($this->dadosCorpoRequest);
                
                return ConstantesGenericasUtil::MSG_ATUALIZADO_SUCESSO;
            }else {
                $this->UsuariosRepository->getMySQL()->getDb()->rollBack();
    
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_NAO_AFETADO);
            }
        }
        

        
    }

}