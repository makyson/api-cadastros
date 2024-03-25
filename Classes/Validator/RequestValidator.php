<?php

namespace Validator;

use InvalidArgumentException;
use Repository\TokensAutorizadosRepository;
use Service\UsuariosService;
use Util\ConstantesGenericasUtil;
use Util\JsonUtil;



class RequestValidator {

    private $request;

    private $dadosRequest = [];

    private object $TokensAutorizadosRepository;

    const GET = 'GET';
    const DELETE = 'DELETE';
    const PUT = 'PUT';
    const POST = 'POST';
    const MOTORISTAS = 'MOTORISTAS';
    const VEICULOS = 'VEICULOS';

    public function __construct($request) {
        
        $this->request = $request;
        $this->TokensAutorizadosRepository = new TokensAutorizadosRepository();
        
    }

    public function processarRequest(){

        $retorno = ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA;
        //$retorno = utf8_encode(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);
        $this->request['metodo'];
        if (in_array($this->request['metodo'], ConstantesGenericasUtil::TIPO_REQUEST, true)) {
            $retorno = $this->direcionarRequest();
        }
        
        return $retorno;

    }

    private function direcionarRequest(){

        //if ($this->request['metodo'] !== self::GET && $this->request['metodo'] !== self::DELETE) {
            $this->dadosRequest = JsonUtil::tratarCorpoRequisicaoJson();
        //}

        //$this->TokensAutorizadosRepository->validarToken(getallheaders()['Authorization']);

        $metodo = $this->request['metodo'];
        
        return $this->$metodo();

    }
    
    private function get(){

        $retorno = ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA;

        if(in_array($this->request['rotas'], ConstantesGenericasUtil::TIPO_GET, true)){

            if ($this->request['rotas']) {
                if (self::MOTORISTAS || self::VEICULOS)
                    $UsuariosService = new UsuariosService($this->request);
                    $retorno = $UsuariosService->validarGet();
            }else{
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }

        }

        return $retorno;
       
    }

    private function delete(){

        $retorno = ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA;

        if(in_array($this->request['rotas'], ConstantesGenericasUtil::TIPO_DELETE, true)){

            if ($this->request['rotas']) {
                if (self::MOTORISTAS || self::VEICULOS)
                    $UsuariosService = new UsuariosService($this->request);
                    $retorno = $UsuariosService->validarDelete();
            }else{
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }

        }

        return $retorno;
       
    }

    private function post(){

        $retorno = ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA;

        if(in_array($this->request['rotas'], ConstantesGenericasUtil::TIPO_POST, true)){

            if ($this->request['rotas']) {
                if (self::MOTORISTAS || self::VEICULOS)
                    $UsuariosService = new UsuariosService($this->request);
                    $UsuariosService->setDadosCorpoRequest($this->dadosRequest);
                    $retorno = $UsuariosService->validarPost();
            }else{
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }

        }

        return $retorno;
       
    }

    private function put(){

        $retorno = ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA;

        if(in_array($this->request['rotas'], ConstantesGenericasUtil::TIPO_PUT, true)){

            if ($this->request['rotas']) {
                if (self::MOTORISTAS || self::VEICULOS)
                    $UsuariosService = new UsuariosService($this->request);
                    $UsuariosService->setDadosCorpoRequest($this->dadosRequest);
                    $retorno = $UsuariosService->validarPut();
            }else{
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }

        }

        return $retorno;
       
    }

}