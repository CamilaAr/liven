<?php

use PHPUnit\Framework\TestCase;

class UsuarioTest extends TestCase
{
    private $baseUrl = 'http://localhost/liven/usuario/';

    public function testGetEnderecosPorUsuarioId()
    {
        $url = $this->baseUrl . 'getusuario.php?usuario_id=1';
        $response = $this->makeGetRequest($url);

        $this->assertEquals(200, $response['http_code'], "Expected 200 but received {$response['http_code']} with body: " . json_encode($response['body']));
        $this->assertIsArray($response['body'], "Expected an array but received: " . json_encode($response['body']));
        $this->assertArrayHasKey('enderecos', $response['body'], "Expected 'enderecos' key in response but received: " . json_encode($response['body']));
        $this->assertIsArray($response['body']['enderecos'], "Expected an array for 'enderecos' but received: " . json_encode($response['body']));
    }

    private function makeGetRequest($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $output = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return [
            'body' => json_decode($output, true),
            'http_code' => $http_code
        ];
    }
}
?>
