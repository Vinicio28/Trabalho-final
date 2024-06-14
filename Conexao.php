<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "academico";

//Criar a conexao
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);

if ($conn->connect_errno) {
    die("Falha na conexão: (" . $conn->connect_errno . ") " . $conn->connect_error);
} else {
    // echo "Conectado ao banco de dados"; // Apenas para depuração
}
?>