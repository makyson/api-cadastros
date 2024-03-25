<?php

namespace Repository;

use DB\MySQL;

class UsuariosRepository{

    private object $MySQL;
    public const TABELA = "motoristas";
    public const VEICULO = "veiculos";
    public const TRANSPORTADORA = "transportadoras";
    public const CLIENTE = "tclientes";

    public function __construct(){

        $this->MySQL = new MySQL();

    }

    public function getMySQL(){

        return $this->MySQL;

    }

    public function insertUser($nome, $cnh, $cpf, $telefone, $cidade, $estado, $endereco,$pipecodecard, $ativo){

        $consultaInsert = 'INSERT INTO '. self::TABELA .' (NomeMotorista, Cnh, Telefone, Cpf, Cidade, Estado, Endereco,PipeCodeCard, Ativo) VALUES (:nome, :cnh, :telefone, :cpf, :cidade, :estado, :endereco,:PipeCodeCard, :ativo)';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaInsert);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cnh', $cnh);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':PipeCodeCard', $pipecodecard);
        $stmt->bindParam(':ativo', $ativo);
        
        $stmt->execute();

        return $stmt->rowCount();

    }

    public function updateUser($id, $dados){

        $consultaUpdate = 'UPDATE '.self::TABELA.' SET NomeMotorista = :nome, Cnh = :cnh, Telefone = :telefone, Cpf = :cpf, Cidade = :cidade, Estado = :estado, Endereco = :endereco, Ativo = :ativo WHERE CodMotorista = :id';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaUpdate);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $dados['NomeMotorista']);
        $stmt->bindParam(':cnh', $dados['Cnh']);
        $stmt->bindParam(':telefone', $dados['Telefone']);
        $stmt->bindParam(':cpf', $dados['Cpf']);
        $stmt->bindParam(':cidade', $dados['Cidade']);
        $stmt->bindParam(':estado', $dados['Estado']);
        $stmt->bindParam(':endereco', $dados['Endereco']);
        $stmt->bindParam(':ativo', $dados['Ativo']);
        
        $stmt->execute();

        return $stmt->rowCount();

    }

    public function updateVeiculo($id, $dados){

        $consultaUpdate = 'UPDATE '.self::VEICULO.' SET PlacaCavalo = :cavalo, PlacaCarreta = :carreta, Tipo = :tipo, Antt = :antt, Ativo = :ativo WHERE CodVeiculo = :id';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaUpdate);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':cavalo', $dados['PlacaCavalo']);
        $stmt->bindParam(':carreta', $dados['PlacaCarreta']);
        $stmt->bindParam(':tipo', $dados['Tipo']);
        $stmt->bindParam(':antt', $dados['Antt']);
        $stmt->bindParam(':ativo', $dados['Ativo']);
        
        $stmt->execute();

        return $stmt->rowCount();

    }

    public function insertVeiculo($cavalo, $carreta, $tipo, $antt,$pipecodecard, $ativo){

        $consultaInsert = 'INSERT INTO '. self::VEICULO .' (PlacaCavalo, PlacaCarreta, Tipo, Antt,PipeCodeCard, Ativo) VALUES (:cavalo, :carreta, :tipo, :antt,:PipeCodeCard, :ativo)';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaInsert);
        $stmt->bindParam(':cavalo', $cavalo);
        $stmt->bindParam(':carreta', $carreta);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':antt', $antt);
        $stmt->bindParam(':ativo', $ativo);
        $stmt->bindParam(':PipeCodeCard', $pipecodecard);
        $stmt->execute();

        return $stmt->rowCount();

    }

    public function insertTransportadora($nome, $telefone, $cnpj, $email, $incricaoEstadual, $cidade, $estado, $endereco, $responsavel,$antt,$pipecodecard, $ativo){

        $consultaInsert = 'INSERT INTO '. self::TRANSPORTADORA .' (Nome, Telefone, Cnpj, Email, InscricaoEstadual, Cidade, Estado, Endereco, Responsavel, Antt, PipeCodeCard, Ativo) VALUES (:nome, :telefone, :cnpj, :email, :inscricaoEstadual, :cidade, :estado, :endereco, :responsavel,:antt, :PipeCodeCard, :ativo)';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaInsert);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':inscricaoEstadual', $incricaoEstadual);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':responsavel', $responsavel);
        $stmt->bindParam(':antt', $antt);
        $stmt->bindParam(':PipeCodeCard', $pipecodecard);
        $stmt->bindParam(':ativo', $ativo);
        
        $stmt->execute();

        return $stmt->rowCount();

    }

    public function updateTransportadora($id, $dados){

        $consultaUpdate = 'UPDATE '.self::TRANSPORTADORA.' SET Nome = :nome, Telefone = :telefone, Cnpj = :cnpj, Email = :email, InscricaoEstadual = :inscricaoEstadual, Cidade = :cidade, Estado = :estado, Endereco = :endereco, Responsavel = :responsavel, Ativo = :ativo WHERE CodTransportadora = :id';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaUpdate);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $dados['Nome']);
        $stmt->bindParam(':telefone', $dados['Telefone']);
        $stmt->bindParam(':cnpj', $dados['Cnpj']);
        $stmt->bindParam(':email', $dados['Email']);
        $stmt->bindParam(':inscricaoEstadual', $dados['InscricaoEstadual']);
        $stmt->bindParam(':cidade', $dados['Cidade']);
        $stmt->bindParam(':estado', $dados['Estado']);
        $stmt->bindParam(':endereco', $dados['Endereco']);
        $stmt->bindParam(':responsavel', $dados['Responsavel']);
        $stmt->bindParam(':ativo', $dados['Ativo']);
        
        $stmt->execute();

        return $stmt->rowCount();

    }

    public function insertCliente($nome, $endereco, $bairro, $cep, $cidade, $uf, $ddd, $telefone, $cnpj, $email, $empresa, $coordenada){

        $consultaInsert = 'INSERT INTO '. self::CLIENTE .' (NomeCliente, EnderecoCliente, BairroCliente, CepCliente, CidadeCliente, UFCliente, DDDCliente, FoneCliente, CnpjCliente, EmailCliente, CodEmpresa, CoordenadaCliente) VALUES (:nome, :endereco, :bairro, :cep, :cidade, :uf, :ddd, :telefone, :cnpj, :email, :empresa, :coordenada)';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaInsert);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':bairro', $bairro);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':uf', $uf);
        $stmt->bindParam(':ddd', $ddd);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':empresa', $empresa);
        $stmt->bindParam(':coordenada', $coordenada);
        
        $stmt->execute();

        return $stmt->rowCount();

    }

    public function updateCliente($id, $dados){

        $consultaUpdate = 'UPDATE '.self::CLIENTE.' SET NomeCliente = :nome, EnderecoCliente = :endereco, BairroCliente = :bairro, CepCliente = :cep, CidadeCliente = :cidade, UFCliente = :uf, DDDCliente = :ddd, FoneCliente = :telefone, CNPJCliente = :cnpj, EmailCliente = :email, CodEmpresa = :empresa, CoordenadaCliente = :coordenada WHERE CodCliente = :id';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaUpdate);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $dados['NomeCliente']);
        $stmt->bindParam(':endereco', $dados['EnderecoCliente']);
        $stmt->bindParam(':bairro', $dados['BairroCliente']);
        $stmt->bindParam(':cep', $dados['CepCliente']);
        $stmt->bindParam(':cidade', $dados['CidadeCliente']);
        $stmt->bindParam(':uf', $dados['UFCliente']);
        $stmt->bindParam(':ddd', $dados['DDDCliente']);
        $stmt->bindParam(':telefone', $dados['FoneCliente']);
        $stmt->bindParam(':cnpj', $dados['CNPJCliente']);
        $stmt->bindParam(':email', $dados['EmailCliente']);
        $stmt->bindParam(':empresa', $dados['CodEmpresa']);
        $stmt->bindParam(':coordenada', $dados['CoordenadaCliente']);
        
        $stmt->execute();

        return $stmt->rowCount();

    }
    

}