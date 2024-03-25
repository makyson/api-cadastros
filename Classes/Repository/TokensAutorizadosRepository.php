<?php

namespace Repository;

use DB\MySQL;
use InvalidArgumentException;
use Util\ConstantesGenericasUtil;

class TokensAutorizadosRepository{

    private object $MySQL;
    public const TABELA = "us";

    public function __construct(){

        $this->MySQL = new MySQL();

    }

    public function validarToken($token){

        $token = str_replace([' ', 'Bearer'], '', $token);

        if ($token) {

            header('HTTP/1.1 200 OK');

            $consultaToken = 'SELECT * FROM ' . self::TABELA . ' WHERE us_senha = :token';
            $stmt = $this->getMySQL()->getDb()->prepare($consultaToken);
            $stmt->bindValue(':token', $token);
            //$stmt->bindValue(':status', ConstantesGenericasUtil::SIM);

            $stmt->execute();

            if ($stmt->rowCount() != 1) {

                header('HTTP/1.1 401 Unauthorized');

                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_TOKEN_NAO_AUTORIZADO);                
                
            }
           
        } else {

            header('HTTP/1.1 401 Unauthorized');
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_TOKEN_VAZIO);
            
        }
        

        //var_dump($token); exit;

    }

    public function getMySQL(){

        return $this->MySQL;

    }

}