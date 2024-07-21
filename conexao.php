<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_endereco";

// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Configura o charset para UTF-8 
$conn->set_charset("utf8");

?>
