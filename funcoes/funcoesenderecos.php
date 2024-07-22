<?php
//Funções referentes a endereço

require_once '../conexao.php';

//com conexão e usuário retorna os endereços
function obterEnderecosPorUsuarioId($conn, $usuario_id) {
    $sql = "SELECT * FROM enderecos WHERE usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $enderecos = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $enderecos;
}


//com conexão e país retorna os endereços
function obterEnderecosPorPais($conn, $country) {
    $sql = "SELECT * FROM enderecos WHERE pais = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $country);
    $stmt->execute();
    $result = $stmt->get_result();
    $enderecos = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $enderecos;
}


//com conexão e id do endereço retorna o endereço
function obterEnderecoPorId($conn, $endereco_id) {
    $sql = "SELECT * FROM enderecos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $endereco_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $endereco = $result->fetch_assoc();
    $stmt->close();
    return $endereco;
}
?>
