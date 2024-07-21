<?php
//código para editar um endereço

require_once '../declara.php'; // Inclui as configurações necessárias
require_once '../funcoes/verificarTokenJWT.php'; // Inclui a função verificarTokenJWT

$user_id = verificarTokenJWT();

// Recebe o ID do endereço via GET
$endereco_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($endereco_id <= 0) {
    http_response_code(400);
    echo json_encode(['mensagem' => 'ID do endereço não fornecido']);
    exit;
}

// Recebe os dados do formulário via JSON
$json = file_get_contents('php://input');
$data = json_decode($json);

if (!isset($data->logradouro) || !isset($data->numero) || !isset($data->cidade) || !isset($data->estado) || !isset($data->pais) || !isset($data->cep)) {
    http_response_code(400);
    echo json_encode(['mensagem' => 'Dados do endereço incompletos']);
    exit;
}

// Atualiza os dados do endereço no banco de dados
$stmt = $conn->prepare("UPDATE enderecos SET logradouro = ?, numero = ?, complemento = ?, bairro = ?, cidade = ?, estado = ?, pais = ?, cep = ? WHERE id = ? AND usuario_id = ?");
$stmt->bind_param("sssssssiii", $data->logradouro, $data->numero, $data->complemento, $data->bairro, $data->cidade, $data->estado, $data->pais, $data->cep, $endereco_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(['mensagem' => 'Endereço atualizado com sucesso']);
} else {
    http_response_code(500);
    echo json_encode(['mensagem' => 'Erro ao atualizar endereço']);
}
?>
