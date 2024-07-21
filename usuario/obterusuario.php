<?php
//Código utilizado para obter um usuário

require_once '../declara.php'; // Inclui as configurações necessárias, como a definição da chave secreta
require_once '../funcoes/verificarTokenJWT.php'; // Inclui a função verificarTokenJWT

$user_id = verificarTokenJWT();

// Consulta os dados do usuário no banco de dados
$stmt = $conn->prepare("SELECT id, nome, email FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();
    
     // Limpe o buffer de saída
     ob_clean();
     // Retorna o token como resposta
     header('Content-Type: application/json');
    echo json_encode($usuario);
} else {
    http_response_code(404);
    echo json_encode(array("mensagem" => "Usuário não encontrado"));
}
?>
