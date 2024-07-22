<?php

//esse código define os testes do endereço

use PHPUnit\Framework\TestCase;

class EnderecoTest extends TestCase
{
    // URL base para acessar os endpoints dos testes de endereço
    private $baseUrl = 'http://localhost/liven/endereco/';

    // Teste para verificar a obtenção de endereços por país
    public function testGetEnderecosPorPais()
    {
        // URL do endpoint para obter endereços por país
        $url = $this->baseUrl . 'getendereco.php?country=BR';
        
        // Realiza a requisição GET para o endpoint
        $response = $this->makeGetRequest($url);

        // Verifica se o código de resposta HTTP é 200 (OK)
        $this->assertEquals(200, $response['http_code'], "Expected 200 but received {$response['http_code']} with body: " . json_encode($response['body']));
        
        // Verifica se o corpo da resposta contém um array chamado 'enderecos'
        $this->assertIsArray($response['body']['enderecos'], "Expected an array for 'enderecos' but received: " . json_encode($response['body']));
    }

    // Teste para verificar a obtenção de um endereço por ID
    public function testGetEnderecoPorId()
    {
        // URL do endpoint para obter um endereço por ID
        $url = $this->baseUrl . 'getendereco.php?id=1';
        
        // Realiza a requisição GET para o endpoint
        $response = $this->makeGetRequest($url);

        // Verifica se o código de resposta HTTP é 200 (OK)
        $this->assertEquals(200, $response['http_code'], "Expected 200 but received {$response['http_code']} with body: " . json_encode($response['body']));
        
        // Verifica se o corpo da resposta é um array
        $this->assertIsArray($response['body'], "Expected an array but received: " . json_encode($response['body']));
        
        // Verifica se o array da resposta contém a chave 'id'
        $this->assertArrayHasKey('id', $response['body'], "Expected 'id' key in response but received: " . json_encode($response['body']));
    }

    // Função auxiliar para realizar requisições GET
    private function makeGetRequest($url)
    {
        // Inicializa a sessão cURL
        $ch = curl_init();

        // Configura a URL para a requisição cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        // Configura para retornar a transferência como uma string do valor de retorno em vez de exibi-la diretamente
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Configura o cabeçalho Content-Type como application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        // Executa a sessão cURL e obtém o conteúdo da resposta
        $output = curl_exec($ch);
        // Obtém o código de resposta HTTP
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Fecha a sessão cURL
        curl_close($ch);

        // Retorna a resposta como um array com o corpo decodificado JSON e o código HTTP
        return [
            'body' => json_decode($output, true),
            'http_code' => $http_code
        ];
    }
}
?>
