<?php

namespace Util;

use InvalidArgumentException;
use JsonException;

class JsonUtil{

    public static function tratarCorpoRequisicaoJson(){

        try {
            $postJson = json_decode(file_get_contents('php://input'), true);
        } catch (JsonException $Exception) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERR0_JSON_VAZIO);
            
        }

        if (is_array($postJson) && count($postJson) > 0) {
            return $postJson;
        }

    }

    public function processarArrayParaRetornar($retorno){

        $dados = [];

        $dados[ConstantesGenericasUtil::TIPO] = ConstantesGenericasUtil::TIPO_ERRO;
        if ((is_array($retorno) && count($retorno) > 0) || (!empty($retorno) && strlen($retorno) > 10)) {
        

            $dados[ConstantesGenericasUtil::TIPO] = ConstantesGenericasUtil::TIPO_SUCESSO;

            $dados[ConstantesGenericasUtil::RESPOSTA] = $retorno;
            
        }

        $this->retornarJson($dados);

    }

 

    public function processarArrayParaRetornarErro($retorno, $codigo = null) {
        $dados = [];
        $dados[ConstantesGenericasUtil::TIPO] = ConstantesGenericasUtil::TIPO_ERRO;
    
        if (is_array($retorno) && count($retorno) > 0 || strlen($retorno) > 1) {
            $dados[ConstantesGenericasUtil::RESPOSTA] = $retorno;
        }
    
        // Adicionando código, se fornecido
        if ($codigo !== null) {
            $dados['variante'] = $codigo;
        }
    
        $this->retornarJson($dados);
    }



    private function retornarJson($json){

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
     
      



        echo json_encode($json);

    }
    
}