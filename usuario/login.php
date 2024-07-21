<?php
//Código utilizado ao realizar uma solicitação de login

require_once '../declara.php'; // Inclui as configurações necessárias, como a definição da chave secreta

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

error_log('login.php: Iniciando processamento do login'); // Log inicial

// Verifica se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log('login.php: Requisição POST recebida'); // Log POST recebido

    // Recebe os dados do formulário via JSON
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    // Verifica se os dados foram recebidos corretamente
    if (!isset($data->email) || !isset($data->senha)) {
        http_response_code(400);
        echo json_encode(['erro' => 'Dados incompletos']);
        exit;
    }

    // Verifica as credenciais no banco de dados
    $email = $data->email;
    $senha = $data->senha;

    // Função para verificar o login (exemplo básico)
    function verificarLogin($email, $senha) {
        global $conn;

        error_log('login.php: Verificando credenciais para ' . $email); // Log de verificação

        // Prepara a query para buscar o usuário pelo e-mail
        $stmt = $conn->prepare("SELECT id, nome, email, senha FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);

        // Executa a query
        $stmt->execute();

        // Obtém o resultado
        $result = $stmt->get_result();

        // Verifica se o usuário existe e se a senha está correta
        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();
            if (password_verify($senha, $usuario['senha'])) {
                return $usuario; // Retorna os dados do usuário
            }
        }

        return null; // Retorna null se as credenciais não forem válidas
    }

    // Verifica o login
    $usuario = verificarLogin($email, $senha);

    // Se as credenciais forem válidas, gera o token JWT
    if ($usuario) {
        error_log('login.php: Credenciais válidas para ' . $email); // Log de credenciais válidas

        // Gera o token JWT
        $payload = [
            'id' => $usuario['id'],
            'nome' => $usuario['nome'],
            'email' => $usuario['email']
           
        ];
        $token = JWT::encode($payload, $chave_secreta, 'HS256');

        error_log('login.php: Token JWT gerado: ' . $token); // Log de token gerado

        // Limpe o buffer de saída
        ob_clean();
        // Retorna o token como resposta
        header('Content-Type: application/json');
        echo json_encode(['token' => $token]);
    } else {
        // Caso as credenciais sejam inválidas
        http_response_code(401);
        echo json_encode(['erro' => 'Credenciais inválidas']);
    }
} else {
    // Se o método da requisição não for POST
    http_response_code(405);
    echo json_encode(['erro' => 'Método não permitido']);
}


?>
