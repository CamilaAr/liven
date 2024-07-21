<?php
//Código utilizado para salvar um novo usuário


require_once '../declara.php'; // Inclui as configurações necessárias, como a conexão com o banco de dados e a definição da chave secreta


// Verifica se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário via JSON
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    // Verifica se os dados foram recebidos corretamente
    if (!isset($data->nome) || !isset($data->email) || !isset($data->senha)) {
        http_response_code(400);
        echo json_encode(['erro' => 'Dados incompletos']);
        exit;
    }

    // Extrai os dados do objeto JSON
    $nome = $data->nome;
    $email = $data->email;
    $senha = $data->senha;

    // Tenta cadastrar o usuário
    if (cadastrarUsuario($nome, $email, $senha)) {
        http_response_code(201); // Created
        echo json_encode(['mensagem' => 'Usuário cadastrado com sucesso']);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['erro' => 'Erro ao cadastrar usuário']);
    }
} else {
    // Se o método da requisição não for POST
    http_response_code(405); // Method Not Allowed
    echo json_encode(['erro' => 'Método não permitido']);
}
?>
