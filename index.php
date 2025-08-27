<?php
require 'config.php';
session_start();
$erro = '';
if (isset($_SESSION['usuario_id'])) {
    header('Location: ' . $base_url . 'produtos/listar.php');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = $_POST['senha'];
    $sql = "SELECT * FROM usuarios WHERE email = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($res && mysqli_num_rows($res) === 1) {
            $user = mysqli_fetch_assoc($res);
            if (password_verify($senha, $user['senha'])) {
                $_SESSION['usuario_id'] = $user['id'];
                $_SESSION['usuario_nome'] = $user['nome'];
                header('Location: ' . $base_url . 'produtos/listar.php');
                exit();
            } else {
                $erro = 'Senha incorreta.';
            }
        } else {
            $erro = 'Usuário não encontrado.';
        }
    } else {
        $erro = 'Erro na consulta.';
    }
}
include 'includes/header.php';
?>
<div class="login-container">
    <h2>Entrar</h2>
    <?php if ($erro): ?><div class="login-error"><?= $erro ?></div><?php endif; ?>
    <form method="post" autocomplete="off">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required autofocus placeholder="Digite seu email">
        </div>
        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required placeholder="Digite sua senha">
        </div>
        <input type="submit" value="Entrar">
    </form>
    <p>Não tem conta? <a href="<?=$base_url?>register.php">Cadastre-se</a></p>
</div>
<?php include 'includes/close.php'; ?>
