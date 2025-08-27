<?php
session_start();
include 'db/conexao.php';

$erro = "";
$cadastro_sucesso = isset($_GET['cadastro']) && $_GET['cadastro'] === 'ok';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($conexao, $sql);

    if ($usuario = mysqli_fetch_assoc($resultado)) {
        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            header("Location: dashboard.php");
            exit();
        } else {
            $erro = "Senha incorreta.";
        }
    } else {
        $erro = "Usuário não encontrado.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Login - Sistema de Estoque</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- CSS personalizado -->
    <link href="css/login.css" rel="stylesheet" />
</head>
<body>

<div class="login-card">
    <h3>Entrar no Sistema</h3>

    <?php if ($cadastro_sucesso): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sucesso!</strong> Cadastro realizado. Faça login abaixo.
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($erro) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="" id="loginForm">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email" required />
            </div>
        </div>

        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" required />
                <button type="button" class="btn btn-outline-light" id="toggleSenha" tabindex="-1">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn btn-login w-100 py-2" id="btnLogin">Entrar</button>
    </form>

    <div class="link-cadastro">
        <small>Não tem conta? <a href="cadastro.php">Criar agora</a></small>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Mostrar / ocultar senha
    const toggleSenha = document.getElementById('toggleSenha');
    const senhaInput = document.getElementById('senha');
    toggleSenha.addEventListener('click', () => {
        const type = senhaInput.type === 'password' ? 'text' : 'password';
        senhaInput.type = type;
        toggleSenha.innerHTML = type === 'password' 
            ? '<i class="bi bi-eye"></i>' 
            : '<i class="bi bi-eye-slash"></i>';
    });

    // Efeito loading no botão
    const loginForm = document.getElementById('loginForm');
    const btnLogin = document.getElementById('btnLogin');

    loginForm.addEventListener('submit', () => {
        btnLogin.disabled = true;
        btnLogin.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Entrando...';
    });

    // Resetar botão ao voltar para a página
    window.addEventListener('pageshow', () => {
        btnLogin.disabled = false;
        btnLogin.innerHTML = 'Entrar';
    });
</script>
</body>
</html>



