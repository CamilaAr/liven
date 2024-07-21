<?php
//funções necessárias para manipulação de usuário

// Função para cadastro de um novo usuário
function cadastrarUsuario($nome, $email, $senha) {
    global $conn;

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $email, $senha_hash);

    if ($stmt->execute()) {
        // Log de sucesso
        error_log('Usuário cadastrado com sucesso: ' . $nome);
        return true;
    } else {
        // Log de erro
        error_log('Erro ao cadastrar usuário: ' . $stmt->error);
        return false;
    }
}

// Função para cadastrar um novo endereço para um usuário
function cadastrarEndereco($usuario_id, $logradouro, $numero, $complemento, $cidade, $estado, $pais, $cep) {
    global $conn;

    // Prepara a query
    $stmt = $conn->prepare("INSERT INTO enderecos (usuario_id, logradouro, numero, complemento, cidade, estado, pais, cep) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $usuario_id, $logradouro, $numero, $complemento, $cidade, $estado, $pais, $cep);

    // Executa a query
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

//Função para trazer um usuário por id
function obterUsuarioPorId($usuario_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT id, nome, email FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
}


//função para obter endereçõs de usuário por id
function obterEnderecosPorUsuarioId($usuario_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT id, logradouro, numero, complemento, cidade, estado, pais, cep FROM enderecos WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $enderecos = array();
    while ($row = $result->fetch_assoc()) {
        $enderecos[] = $row;
    }
    return $enderecos;
}
?>
?>
