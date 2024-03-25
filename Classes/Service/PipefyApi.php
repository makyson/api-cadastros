<?php

/*

Documentação da Classe PipefyApi
A classe PipefyApi é responsável por interagir com a API do Pipefy para realizar operações como criar, atualizar e excluir cartões.

Métodos Públicos:
createCardWithFields:

Descrição: Cria um novo cartão em um determinado pipe com os campos e valores fornecidos.
Parâmetros:
$id_pipe: ID do pipe onde o cartão será criado.
$id_grupo: ID do grupo onde o cartão será colocado.
$campo: Array contendo os IDs dos campos a serem preenchidos no cartão.
$value: Array contendo os valores a serem atribuídos aos campos.
Retorno: Retorna uma mensagem indicando o sucesso da operação ou lança uma exceção em caso de erro.
updateCardFields:

Descrição: Atualiza os valores dos campos de um cartão existente.
Parâmetros:
$cardId: ID do cartão que será atualizado.
$campo: Array contendo os IDs dos campos a serem atualizados.
$value: Array contendo os novos valores dos campos.
Retorno: Retorna uma mensagem indicando o sucesso da operação ou lança uma exceção em caso de erro.
deleteCard:

Descrição: Exclui um cartão existente.
Parâmetros:
$cardId: ID do cartão que será excluído.
Retorno: Retorna true se o cartão foi excluído com sucesso, caso contrário retorna false.
Métodos Privados:
executeMutation:

Descrição: Executa uma mutação GraphQL na API do Pipefy.
Parâmetros: $mutation: A mutação GraphQL a ser executada.
Retorno: Retorna a resposta da API após a execução da mutação.
backupCurrentValues:

Descrição: Faz backup dos valores atuais dos campos de um cartão.
Parâmetros: $cardId: ID do cartão para o qual os valores serão backupados.
performUpdate:

Descrição: Executa a atualização dos campos de um cartão.
Parâmetros: $cardId: ID do cartão a ser atualizado, $campo: Array contendo os IDs dos campos a serem atualizados, $value: Array contendo os novos valores dos campos.
restoreBackupValues:

Descrição: Restaura os valores antigos dos campos de um cartão em caso de erro.
Parâmetros: $cardId: ID do cartão para o qual os valores antigos serão restaurados.
executeQuery:

Descrição: Executa uma consulta GraphQL na API do Pipefy.
Parâmetros: $query: A consulta GraphQL a ser executada.
Retorno: Retorna a resposta da API após a execução da consulta.
Fluxo de Operações
O usuário chama um dos métodos públicos da classe PipefyApi para realizar uma operação (criar, atualizar ou excluir cartão).
O método constrói uma mutação GraphQL com base nos parâmetros fornecidos.
A mutação GraphQL é executada na API do Pipefy.
Se a operação for bem-sucedida, uma mensagem de sucesso é retornada. Caso contrário, uma exceção é lançada.
Para operações de atualização, os valores atuais dos campos são backupados antes da atualização.
Se ocorrer um erro durante a atualização, os valores antigos são restaurados.
Para operações de exclusão, o método retorna true se o cartão foi excluído com sucesso, caso contrário retorna false.
Espero que essa documentação e fluxo de operações ajudem a entender como a classe PipefyApi interage com a API do Pipefy.



   +---------------------+----------------------+---------------------+
   |   createCardWithFields         |       updateCardFields        |              deleteCard                 |
   |                                   |                                           |                                     |
   +---------------------------------+----------------------+---------------------+
   |                                           |                                           |                                      |
   |      Seleção de Método           |      Seleção de Método       |         Seleção de Método   |
   |                                           |                                           |                                      |
   +------------------|----------------------+---------------------+
                                               |                                         |                                      |
                                               v                                       |                                      |
   +------------------|----------------------+---------------------+
   |      Consulta GraphQL         |     Consulta GraphQL                     |   Consulta GraphQL    |
   |  para obter ID de campos         |  para obter valores atuais              |  para obter ID do     |
   |                                  |   dos campos do cartão                   |  cartão                                 |
   +------------------|----------------------+---------------------+
                                             |                                        |                                      |
                                             v                                       |                                      |
   +------------------|----------------------+---------------------+
   |    Mutação GraphQL para  |  Mutação GraphQL para                    |  Mutação GraphQL para  |
   |  criar o cartão com           |  atualizar os campos do              |  deletar o cartão           |
   |  campos especificados        |  cartão com novos valores                       |                                      |
   +------------------|----------------------+---------------------+
                                             |                                       |                                      |
                                             v                                         |                                      |
   +------------------|----------------------+---------------------+
   |    Processamento de           |    Processamento de                      |    Processamento de         |
   |  resposta e retorno          |  resposta e retorno                      |  resposta e retorno       |
   |  de resultado                      |  de resultado                         |  de resultado                     |
   |                                           |  (sucesso ou falha)                |  (sucesso ou falha)           |
   +------------------+----------------------+---------------------+



Exemplo 

/



/////    create    ///////

   PipefyApi::createCardWithFields(
                        id_pipe: "304023091", 
                        id_grupo: "324824268",
                        campo: [
                            "placa_do_cavalo_mec_nico_1",
                            "copy_of_placa_do_cavalo_mec_nico_1",
                            "tipo_ve_culo",
                            "s"
                        ], 
                        value: [
                            "Rodotrem - Peso Bruto 74 ton",
                            "Rodotrem - Peso Bruto 74 ton",
                            "Rodotrem - Peso Bruto 74 ton",
                            "111111"
                        ]
                    );

/////    update    ///////

                        PipefyApi::updateCardFields(
                            cardId: 896243675, 
                            campo: [
                                "placa_do_cavalo_mec_nico_1",
                                "copy_of_placa_do_cavalo_mec_nico_1",
                                "tipo_ve_culo",
                                "s"
                            ],
                            value: [
                                "12aa",
                                "22",
                                "Rodotrem - Peso Bruto 74 ton",
                                "32"
                            ]
                        );


/////    delete    ///////

                        PipefyApi::deleteCard("896295509");
             
                        

verifica a estrutura
















*/

//Existe uma estrura lá













/**
 * Classe que fornece métodos para interagir com a API do Pipefy.
 */




 namespace Service;

 use Exception;
 use InvalidArgumentException;
 use Util\ConstantesGenericasUtil;



 

class PipefyApi {
    private static $apiUrl = 'https://api.pipefy.com/graphql';
    private static $backupData = []; // Armazenar dados de backup dos campos
    private static $accessToken = 'eyJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJQaXBlZnkiLCJpYXQiOjE3MTA5NjQxNDYsImp0aSI6IjVkMzI3Mzc0LTVlNjktNGE4Ni05YTlhLTJmZjRjZjJjMjE5NyIsInN1YiI6MzMyNzI1LCJ1c2VyIjp7ImlkIjozMzI3MjUsImVtYWlsIjoibWFyY29zLmdlc3NvaW50ZWdyYWxAZ21haWwuY29tIiwiYXBwbGljYXRpb24iOjMwMDMzNDkzOCwic2NvcGVzIjpbXX0sImludGVyZmFjZV91dWlkIjpudWxsfQ.vEdr_0knGSJNP8-SWsIJK1xjtLnXOvLITSqDTx1GYGe4FL2pxB8K0MDwMprwcd9svEL9Awdu4yIgBTg8ewDdTg'; // Substitua pelo seu token
    





    /**
     * Cria um novo cartão com os campos especificados.
     *
     * @param array $args Um array associativo contendo os seguintes parâmetros:
     *   - 'id_pipe': O ID do pipe onde o cartão será criado.
     *   - 'id_grupo': O ID do grupo onde o cartão será colocado.
     *   - 'campo': Um array contendo os IDs dos campos a serem preenchidos no cartão.
     *   - 'value': Um array contendo os valores a serem atribuídos aos campos.
     * @return string Uma mensagem indicando o sucesso da operação.
     * @throws InvalidArgumentException Se algum parâmetro estiver faltando ou inválido.
     */
    public static function CreateCardWithFields($id_pipe, $id_grupo, $campo, $value) {
        // Constrói a mutação GraphQL com base nos campos fornecidos
        $mutation = 'mutation { createCard(input: { pipe_id: ' . $id_pipe . ', phase_id: "' . $id_grupo . '", ';
        $mutation .= 'fields_attributes: [';

        // Adiciona cada campo fornecido à mutação
        foreach ($campo as $key => $fieldId) {
            $mutation .= '{ field_id: "' . $fieldId . '", field_value: "' . $value[$key] . '" }, ';
        }

        // Remove a vírgula extra no final
        $mutation = rtrim($mutation, ", ");
        
        // Completa a mutação GraphQL
        $mutation .= ']}) { card { id } } }';

        // Inicia uma nova requisição cURL
        $curl = curl_init();

        // Configura as opções da requisição cURL
        curl_setopt_array($curl, [
            CURLOPT_URL => self::$apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode(['query' => $mutation]),
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer " . self::$accessToken,
                "content-type: application/json"
            ],
        ]);

        // Executa a requisição cURL e armazena a resposta
        $response = curl_exec($curl);
        $err = curl_error($curl);

        // Fecha a requisição cURL
        curl_close($curl);

        // Verifica se houve algum erro na requisição
        if ($err) {
            // Em caso de erro, retorna uma string indicando erro
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_SERVICO_TERCERIZADO_ERRO);
          
        } else {
            // Verifica se o cartão foi criado com sucesso
            $responseData = json_decode($response, true);
            if (isset($responseData['data']['createCard']['card']['id'])) {
                // Cartão criado com sucesso
                return $responseData['data']['createCard']['card']['id'] ;
            } else {
                // Falha ao criar o cartão
                if ('Invalid inputs: Erro no campo "CPF": Value deve ser único' == $responseData['errors'][0]['message']) {
                  
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_PIPEFY_CPF_EXISTE. ConstantesGenericasUtil::NumeroBot);
                }
                else{


                
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_SERVICO_TERCERIZADO_ERRO);
            }


            }
        }
    }


    /**
     * Deleta um cartão com o ID especificado.
     *
     * @param string $cardId O ID do cartão a ser deletado.
     * @return bool True se o cartão foi deletado com sucesso, False caso contrário.
     */
    public static function DeleteCard(string $cardId) {
        // Constrói a mutação GraphQL para deletar o cartão
        $mutation = 'mutation {
            deleteCard(input: {id: "' . $cardId . '"}) {
                success
            }
        }';

        // Executa a mutação GraphQL para deletar o cartão
        $response = self::executeMutation($mutation);

        // Decodifica a resposta JSON
        $responseData = json_decode($response, true);

        // Verifica se o cartão foi deletado com sucesso
        if (isset($responseData['data']['deleteCard']['success']) && $responseData['data']['deleteCard']['success']) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Atualiza os campos de um cartão com os valores especificados.
     *
     * @param int $cardId O ID do cartão a ser atualizado.
     * @param array $campo Um array contendo os IDs dos campos a serem atualizados.
     * @param array $value Um array contendo os novos valores para os campos.
     * @throws InvalidArgumentException Se os arrays 'campo' e 'value' não tiverem o mesmo número de elementos.
     * @throws InvalidArgumentException Se ocorrer algum erro ao executar a atualização dos campos.
     */
    public static function UpdateCardFields(int $cardId, array $campo, array $value) {
        if (count($campo) !== count($value)) {
            throw new InvalidArgumentException("Os arrays 'campo' e 'value' devem ter o mesmo número de elementos.");
        }

        // Faz backup dos valores atuais dos campos
        self::backupCurrentValues($cardId);

        try {
            // Executa as atualizações dos campos
            self::performUpdate($cardId, $campo, $value);
        } catch (Exception $e) {
            // Em caso de erro, restaura os valores antigos
            self::restoreBackupValues($cardId);
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_SERVICO_TERCERIZADO_ERRO);

          
        }
    }

    /**
     * Executa uma mutação GraphQL e retorna a resposta.
     *
     * @param string $mutation A mutação GraphQL a ser executada.
     * @return string A resposta da execução da mutação.
     * @throws InvalidArgumentException Se ocorrer algum erro na execução da mutação.
     */
    private static function executeMutation($mutation) {
        // Inicia uma nova requisição cURL
        $curl = curl_init();

        // Configura as opções da requisição cURL
        curl_setopt_array($curl, [
            CURLOPT_URL => self::$apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode(['query' => $mutation]),
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer " . self::$accessToken,
                "content-type: application/json"
            ],
        ]);

        // Executa a requisição cURL e armazena a resposta
        $response = curl_exec($curl);
        $err = curl_error($curl);

        // Fecha a requisição cURL
        curl_close($curl);

        // Verifica se houve algum erro na requisição
        if ($err) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_SERVICO_TERCERIZADO_ERRO);

        }

        return $response;
    }


    /**
     * Realiza uma consulta GraphQL e retorna a resposta.
     *
     * @param string $query A consulta GraphQL a ser executada.
     * @return string A resposta da consulta GraphQL.
     * @throws InvalidArgumentException Se ocorrer algum erro na execução da consulta.
     */
    private static function executeQuery(string $query): string {
        // Inicia uma nova requisição cURL
        $curl = curl_init();

        // Configura as opções da requisição cURL
        curl_setopt_array($curl, [
            CURLOPT_URL => self::$apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode(['query' => $query]),
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer " . self::$accessToken,
                "content-type: application/json"
            ],
        ]);

        // Executa a requisição cURL e armazena a resposta
        $response = curl_exec($curl);
        $err = curl_error($curl);

        // Fecha a requisição cURL
        curl_close($curl);

        // Verifica se houve algum erro na requisição
        if ($err) {
             throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_SERVICO_TERCERIZADO_ERRO);
        }

        return $response;
    }


    /**
     * Realiza o backup dos valores atuais dos campos de um cartão.
     *
     * @param int $cardId O ID do cartão a ter os valores de campo backupados.
     */
    private static function backupCurrentValues(int $cardId) {
        // Query para obter os valores atuais dos campos do cartão
        $query = '{
            card(id: ' . $cardId . ') {
                fields {
                    field {
                        id
                    }
                    value
                }
            }
        }';

        // Realiza a consulta GraphQL para obter os valores atuais dos campos
        $response = self::executeQuery($query);

        // Decodifica a resposta JSON
        $responseData = json_decode($response, true);

        // Armazena os valores atuais dos campos
        self::$backupData[$cardId] = $responseData['data']['card']['fields'];
    }

    /**
     * Executa as atualizações dos campos de um cartão.
     *
     * @param int $cardId O ID do cartão a ser atualizado.
     * @param array $campo Um array contendo os IDs dos campos a serem atualizados.
     * @param array $value Um array contendo os novos valores para os campos.
     * @throws Exception Se ocorrer algum erro ao executar a atualização dos campos.
     */
   
     private static function performUpdate(int $cardId, array $campo, array $value) {
        // Constrói a mutação GraphQL com base nos campos fornecidos
        $mutation = 'mutation {';
        $responses = '';

        // Loop através dos campos
        foreach ($campo as $key => $fieldId) {
            // Adiciona atualização à mutação
            $mutation .= 'n' . ($key + 1) . ': updateCardField(input: {card_id: ' . $cardId . ', field_id: "' . $fieldId . '", new_value: "' . $value[$key] . '"}) { card { id } success } ';
        }

        $mutation .= '}';

        // Executa a mutação GraphQL para realizar a atualização dos campos
        $response = self::executeQuery($mutation);
        
        // Decodifica a resposta JSON
        $responseData = json_decode($response, true);

        // Verifica se todas as atualizações foram bem-sucedidas
        foreach ($responseData['data'] as $key => $result) {
            if (!$result['success']) {
                throw new Exception("Falha ao atualizar o campo com ID: " . $campo[$key]);
            }
        }
    }


    /**
     * Restaura os valores de backup dos campos de um cartão.
     *
     * @param int $cardId O ID do cartão a ter os valores de campo restaurados.
     */
    private static function restoreBackupValues(int $cardId) {
        if (isset(self::$backupData[$cardId])) {
            // Obtém os valores de backup dos campos
            $backupFields = self::$backupData[$cardId];

            // Constrói a mutação GraphQL para restaurar os valores antigos
            $mutation = 'mutation {';
            
            foreach ($backupFields as $key => $field) {
                $mutation .= 'n' . ($key + 1) . ': updateCardField(input: {card_id: ' . $cardId . ', field_id: "' . $field['field']['id'] . '", new_value: "' . $field['value'] . '"}) { card { id } success } ';
            }
            
            $mutation .= '}';

            // Executa a mutação GraphQL para restaurar os valores antigos
            $response = self::executeQuery($mutation);
        }
    }

   
}
