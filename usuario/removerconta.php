<?php
//Código utilizado para apagar um usuário

require_once '../declara.php'; // Inclui as configurações necessárias
require_once '../funcoes/verificarTokenJWT.php'; // Inclui a função verificarTokenJWT

$user_id = verificarTokenJWT();

// Remove a conta do usuário do banco de dados
$stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    echo json_encode(['mensagem' => 'Conta removida com sucesso']);
} else {
    http_response_code(500);
    echo json_encode(['mensagem' => 'Erro ao remover conta']);
}
?>
