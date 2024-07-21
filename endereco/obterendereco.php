<?php
//código para obter apenas um endereço


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

// Consulta o endereço no banco de dados
$stmt = $conn->prepare("SELECT id, logradouro, numero, complemento, bairro, cidade, estado, pais, cep FROM enderecos WHERE id = ? AND usuario_id = ?");
$stmt->bind_param("ii", $endereco_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $endereco = $result->fetch_assoc();
     // Limpe o buffer de saída
     ob_clean();
     // Retorna o token como resposta
     header('Content-Type: application/json');
    echo json_encode($endereco);
} else {
    http_response_code(404);
    echo json_encode(['mensagem' => 'Endereço não encontrado']);
}
?>
