<?php

use Util\ConstantesGenericasUtil;
use Util\JsonUtil;
use Util\RotasUtil;
use Validator\RequestValidator;

include 'bootstrap.php';


try {

    $RequestValidator = new RequestValidator(RotasUtil::getRotas());

    $retorno = $RequestValidator->processarRequest();

    //var_dump($retorno);

    $JsonUtil = new JsonUtil();

    $JsonUtil->processarArrayParaRetornar($retorno);
    
} catch (Exception $exception) {

    $JsonUtil = new JsonUtil();

   
    // Decodificando o JSON para um array associativo
    $jsonData = $exception->getMessage();
    
    // Inicializando as variáveis
    $mensagem = '';
    $code = null;
    
    // Verificando se há um código na resposta
    if (preg_match('/#code:(.+)/', $jsonData, $matches)) {
        $mensagem = trim(str_replace($matches[0], '', $jsonData));
        $code = $matches[1];
    } else {

        $mensagem = trim(str_replace("#code:", "", $jsonData));
        
   
    }


    $JsonUtil->processarArrayParaRetornarErro($mensagem,$code);

   

    exit;

}