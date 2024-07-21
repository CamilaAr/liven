<?php
require_once '../conexao.php'; // Inclui a função para obter a conexão com o banco de dados
require_once '../funcoes/funcoesenderecos.php'; // Inclui as funções para obter endereços

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {


        // Check if 'country' query parameter is set
        if (isset($_GET['country'])) {
            $country = $_GET['country'];
            error_log('Obtendo endereços para o país: ' . $country);
            $enderecosUsuario = obterEnderecosPorPais($conn, $country);

            if ($enderecosUsuario) {
                http_response_code(200);
                echo json_encode(['enderecos' => $enderecosUsuario]);
            } else {
                error_log('Nenhum endereço encontrado para o país: ' . $country);
                http_response_code(404);
                echo json_encode(['erro' => 'Nenhum endereço encontrado para o país especificado']);
            }
        } 
        // Check if 'id' query parameter is set
        else if (isset($_GET['id'])) {
            $endereco_id = $_GET['id'];
            error_log('Obtendo endereço para o ID: ' . $endereco_id);
            $enderecoUsuario = obterEnderecoPorId($conn, $endereco_id);

            if ($enderecoUsuario) {
                http_response_code(200);
                echo json_encode($enderecoUsuario);
            } else {
                error_log('Endereço não encontrado para o ID: ' . $endereco_id);
                http_response_code(404);
                echo json_encode(['erro' => 'Endereço não encontrado para o ID especificado']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['erro' => 'Parâmetro não fornecido']);
        }

        $conn->close();
    } catch (Exception $e) {
        error_log('Erro: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['erro' => 'Erro interno do servidor: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['erro' => 'Método não permitido']);
}
?>
