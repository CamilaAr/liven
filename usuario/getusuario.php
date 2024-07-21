<?php
require_once '../conexao.php'; // Inclui a função para obter a conexão com o banco de dados
require_once '../funcoes/funcoesenderecos.php'; // Inclui as funções para obter endereços

if ($_SERVER['REQUEST_METHOD'] === 'GET') {


    try {
        // Check if 'usuario_id' query parameter is set
        if (isset($_GET['usuario_id'])) {
            $usuario_id = $_GET['usuario_id'];
            error_log('Obtendo endereços para o usuário ID: ' . $usuario_id);
            $enderecosUsuario = obterEnderecosPorUsuarioId($conn, $usuario_id);

            if (!empty($enderecosUsuario)) {
                http_response_code(200);
                echo json_encode(['enderecos' => $enderecosUsuario]);
            } else {
                error_log('Nenhum endereço encontrado para o usuário ID: ' . $usuario_id);
                http_response_code(200);
                echo json_encode(['enderecos' => []]); // Retornando array vazio
            }
        } else {
            http_response_code(200);
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
