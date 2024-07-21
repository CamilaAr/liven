<?php
//código para cadastrar um endereço

require_once '../declara.php'; // Inclui as configurações necessárias
require_once '../funcoes/verificarTokenJWT.php'; // Inclui a função verificarTokenJWT

$user_id = verificarTokenJWT();

// Recebe os dados do formulário via JSON
$json = file_get_contents('php://input');
$data = json_decode($json);

if (!isset($data->logradouro) || !isset($data->numero) || !isset($data->cidade) || !isset($data->estado) || !isset($data->pais) || !isset($data->cep)) {
    http_response_code(400);
    echo json_encode(['mensagem' => 'Dados do endereço incompletos']);
    exit;
}

// Insere o novo endereço no banco de dados
$stmt = $conn->prepare("INSERT INTO enderecos (usuario_id, logradouro, numero, complemento, bairro, cidade, estado, pais, cep) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issssssss", $user_id, $data->logradouro, $data->numero, $data->complemento, $data->bairro, $data->cidade, $data->estado, $data->pais, $data->cep);

if ($stmt->execute()) {
    echo json_encode(['mensagem' => 'Endereço cadastrado com sucesso']);
} else {
    http_response_code(500);
    echo json_encode(['mensagem' => 'Erro ao cadastrar endereço']);
}
?>
