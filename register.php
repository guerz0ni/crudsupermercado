<?php
require 'config.php';
session_start();
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = $_POST['senha'];
    $senha2 = $_POST['senha2'];
    if ($senha !== $senha2) {
        $erro = 'As senhas não coincidem.';
    } else {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'sss', $nome, $email, $senha_hash);
            if (mysqli_stmt_execute($stmt)) {
                header('Location: ' . $base_url . 'index.php?cadastro=1');
                exit();
            } else {
                $erro = 'Email já cadastrado ou erro no cadastro.';
            }
        } else {
            $erro = 'Erro na preparação da consulta.';
        }
    }
}
include 'includes/header.php';
?>
<div class="register-container">
    <h2>Cadastrar Usuário</h2>
    <?php if ($erro): ?><div class="register-error"><?= $erro ?></div><?php endif; ?>
    <form method="post" autocomplete="off">
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required placeholder="Digite seu nome completo">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required placeholder="Digite seu email">
        </div>
        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required placeholder="Digite sua senha">
        </div>
        <div class="form-group">
            <label for="senha2">Confirmar Senha:</label>
            <input type="password" name="senha2" id="senha2" required placeholder="Confirme sua senha">
        </div>
        <input type="submit" value="Cadastrar">
    </form>
    <p>Já tem conta? <a href="<?=$base_url?>index.php">Entrar</a></p>
</div>
<?php include 'includes/close.php'; ?>
