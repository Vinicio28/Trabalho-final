<?php
include 'Conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];
    $email = $_POST['email'];

    if ($pass != $confirm_pass) {
        echo "As senhas não coincidem.";
    } else {
        // Hash da senha
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

        // Preparando a declaração SQL
        $stmt = $mysqli->prepare("INSERT INTO usuarios (username, password, email) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Erro na preparação: " . $mysqli->error);
        }
        $stmt->bind_param("sss", $user, $hashed_pass, $email);

        if ($stmt->execute()) {
            header("Location: login.html");
            exit();
        } else {
            echo "Erro: " . $stmt->error;
        }

        $stmt->close();
    }
}
$mysqli->close();
?>
