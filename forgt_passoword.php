<?php
include "Conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Verifique se o e-mail existe no banco de dados
    $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE email = ?");
    if (!$stmt) {
        die("Erro na preparação: " . $mysqli->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Gera um token único
        $token = bin2hex(random_bytes(50));

        // Insere o token e o timestamp no banco de dados
        $stmt = $mysqli->prepare("UPDATE usuarios SET reset_token = ?, reset_expires = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?");
        if (!$stmt) {
            die("Erro na preparação: " . $mysqli->error);
        }
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        // Envia o e-mail com o link de recuperação
        $reset_link = "http://seusite.com/reset-password.php?token=" . $token;
        $subject = "Recuperação de Senha";
        $message = "Clique no link para redefinir sua senha: " . $reset_link;
        $headers = "From: noreply@seusite.com";

        mail($email, $subject, $message, $headers);

        echo "Um e-mail de recuperação foi enviado para seu endereço de e-mail.";
    } else {
        echo "E-mail não encontrado.";
    }
    $stmt->close();
}
$mysqli->close();
?>
