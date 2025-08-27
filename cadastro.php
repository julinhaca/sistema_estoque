<?php
include 'db/conexao.php';

$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome  = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";

    if (mysqli_query($conexao, $sql)) {
        header("Location: login.php?cadastro=ok");
        exit();
    } else {
        if (mysqli_errno($conexao) == 1062) {
            $erro = "Este e-mail já está cadastrado.";
        } else {
            $erro = "Erro ao cadastrar: " . mysqli_error($conexao);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Criar Conta - Sistema de Estoque</title>
    <!-- Bootstrap CSS e Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            height: 100vh;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card-cadastro {
            width: 400px;
            padding: 2.5rem;
            border-radius: 1rem;
            background-color: #ffffffdd;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease;
        }
        .card-cadastro:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.35);
        }
        .form-control:focus {
            border-color: #2575fc;
            box-shadow: 0 0 0 0.25rem rgba(37, 117, 252, 0.25);
        }
        .input-group-text {
            background-color: #2575fc;
            color: white;
            border: none;
        }
        .btn-cadastrar {
            background-color: #2575fc;
            border: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .btn-cadastrar:hover {
            background-color: #1a4fcc;
        }
        .erro {
            margin-top: 1rem;
        }
    </style>
</head>
<body>

<div class="card card-cadastro">
    <h3 class="mb-4 text-center fw-bold">Criar Conta</h3>

    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger erro" role="alert">
            <?= htmlspecialchars($erro) ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Seu nome" required />
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                <input type="email" class="form-control" id="email" name="email" placeholder="Seu email" required />
            </div>
        </div>

        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" class="form-control" id="senha" name="senha" placeholder="Sua senha" required />
            </div>
        </div>

        <button type="submit" class="btn btn-cadastrar w-100 py-2">Cadastrar</button>
    </form>

    <div class="mt-3 text-center">
        <small>Já tem conta? <a href="login.php">Entrar</a></small>
    </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>


