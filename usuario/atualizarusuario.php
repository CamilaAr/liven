<?php
//Código utilizado para salvar edições do usuário


require_once '../declara.php'; // Inclui as configurações necessárias, como a definição da chave secreta
require_once '../funcoes/verificarTokenJWT.php'; // Inclui a função verificarTokenJWT

$user_id = verificarTokenJWT();

// Recebe os dados do formulário via JSON
$json = file_get_contents('php://input');
$data = json_decode($json);

if (!isset($data->nome)) {
    http_response_code(400);
    echo json_encode(['mensagem' => 'Nome não fornecido']);
    exit;
}

// Atualiza os dados do usuário no banco de dados
$stmt = $conn->prepare("UPDATE usuarios SET nome = ? WHERE id = ?");
$stmt->bind_param("si", $data->nome, $user_id);

if ($stmt->execute()) {
    echo json_encode(['mensagem' => 'Dados atualizados com sucesso']);
} else {
    http_response_code(500);
    echo json_encode(['mensagem' => 'Erro ao atualizar dados']);
}
?>
