<?php

use PHPUnit\Framework\TestCase;

class EnderecoTest extends TestCase
{
    private $baseUrl = 'http://localhost/liven/endereco/';

    public function testGetEnderecosPorPais()
    {
        $url = $this->baseUrl . 'getendereco.php?country=BR';
        $response = $this->makeGetRequest($url);

        $this->assertEquals(200, $response['http_code'], "Expected 200 but received {$response['http_code']} with body: " . json_encode($response['body']));
        $this->assertIsArray($response['body']['enderecos'], "Expected an array for 'enderecos' but received: " . json_encode($response['body']));
    }

    public function testGetEnderecoPorId()
    {
        $url = $this->baseUrl . 'getendereco.php?id=1';
        $response = $this->makeGetRequest($url);

        $this->assertEquals(200, $response['http_code'], "Expected 200 but received {$response['http_code']} with body: " . json_encode($response['body']));
        $this->assertIsArray($response['body'], "Expected an array but received: " . json_encode($response['body']));
        $this->assertArrayHasKey('id', $response['body'], "Expected 'id' key in response but received: " . json_encode($response['body']));
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
