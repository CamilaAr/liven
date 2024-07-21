<?php
//codigo para apagar um endereço


require_once '../declara.php'; // Inclui as configurações necessárias
require_once '../funcoes/verificarTokenJWT.php'; // Inclui a função verificarTokenJWT

$user_id = verificarTokenJWT();

// Recebe o ID do endereço via JSON
$json = file_get_contents('php://input');
$data = json_decode($json);


if (!isset($data->id)) {
    http_response_code(400);
    echo json_encode(['mensagem' => 'ID do endereço não fornecido']);
    exit;
}

// Remove o endereço do banco de dados
$stmt = $conn->prepare("DELETE FROM enderecos WHERE id = ? AND usuario_id = ?");
$stmt->bind_param("ii", $data->id, $user_id);

if ($stmt->execute()) {
    echo json_encode(['mensagem' => 'Endereço removido com sucesso']);
} else {
    http_response_code(500);
    echo json_encode(['mensagem' => 'Erro ao remover endereço']);
}
?>
