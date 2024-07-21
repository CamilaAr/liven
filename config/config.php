<?php
//traz configurações básicas do sistema


require_once '../vendor/autoload.php'; // Caminho para o autoload da biblioteca JWT

use Firebase\JWT\JWT;

$chave_secreta = 'sua_chave_secreta_aqui'; // chave para desenvolvimento -- salve a chave como variavel de ambiente ao utilizar o código em produção

// Função para gerar token JWT 
function gerarToken($usuario_id, $nome, $email) {
    global $chave_secreta;

    $payload = array(
        "id" => $usuario_id,
        "nome" => $nome,
        "email" => $email,
        "iat" => time(),
        "exp" => time() + (60*60) // Token expira em 1 hora
    );

    return JWT::encode($payload, $chave_secreta, 'HS256');
}
?>
