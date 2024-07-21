<?php
//codigo para obter todos os endereços do usuário


require_once '../declara.php'; // Inclui as configurações necessárias
require_once '../funcoes/verificarTokenJWT.php'; // Inclui a função verificarTokenJWT

$user_id = verificarTokenJWT();

// Consulta os endereços do usuário no banco de dados
$stmt = $conn->prepare("SELECT id, logradouro, numero, complemento, bairro, cidade, estado, pais, cep FROM enderecos WHERE usuario_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$enderecos = [];
while ($endereco = $result->fetch_assoc()) {
    $enderecos[] = $endereco;
    echo $endereco;
}

// Limpe o buffer de saída
ob_clean();
// Retorna o token como resposta
header('Content-Type: application/json');
echo json_encode($enderecos);
?>

