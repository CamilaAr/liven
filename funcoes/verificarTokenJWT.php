<?php
//Código utilizado para varificar o token


require_once '../config/config.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Função para verificar e decodificar o token JWT
function verificarTokenJWT() {
    global $chave_secreta;

    $headers = apache_request_headers();
    $token = isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : null;

    error_log('verificarTokenJWT.php: Token recebido: ' . $token); // Log do token recebido

    if (!$token) {
        http_response_code(401);
        echo json_encode(array("mensagem" => "Token não fornecido"));
        exit;
    }

    try {
        $decoded = JWT::decode($token, new Key($chave_secreta, 'HS256'));
        error_log('verificarTokenJWT.php: Token decodificado com sucesso: ' . json_encode($decoded)); // Log do token decodificado
        return $decoded->id; // Retorna o ID do usuário do token decodificado
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(array("mensagem" => "Token inválido: " . $e->getMessage()));
        exit;
    }
}
?>
