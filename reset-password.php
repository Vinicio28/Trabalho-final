<?php
include 'Conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    if ($pass != $confirm_pass) {
        echo "As senhas não coincidem.";
    } else {
        // Verifica se o token é válido e não expirou
        $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE reset_token = ? AND reset_expires > NOW()");
        if (!$stmt) {
            die("Erro na preparação: " . $mysqli->error);
        }
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Hash da nova senha
            $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

            // Atualiza a senha no banco de dados
            $stmt = $mysqli->prepare("UPDATE usuarios SET password = ?, reset_token = NULL, reset_expires = NULL WHERE reset_token = ?");
            if (!$stmt) {
                die("Erro na preparação: " . $mysqli->error);
            }
            $stmt->bind_param("ss", $hashed_pass, $token);
            $stmt->execute();

            echo "Sua senha foi redefinida com sucesso.";
        } else {
            echo "Token inválido ou expirado.";
        }
        $stmt->close();
    }
}
$mysqli->close();
?>
