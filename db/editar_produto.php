<?php
session_start();
include 'conexao.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID do produto não especificado.");
}

$sql = $conexao->prepare("SELECT * FROM produtos WHERE id = ?");
$sql->bind_param("i", $id);
$sql->execute();
$resultado = $sql->get_result();
$produto = $resultado->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = str_replace(',', '.', $_POST['preco']);
    $quantidade = $_POST['quantidade'];

    $atualizar = $conexao->prepare("UPDATE produtos SET nome=?, descricao=?, preco=?, quantidade_estoque=? WHERE id=?");
    $atualizar->bind_param("ssdii", $nome, $descricao, $preco, $quantidade, $id);
    $atualizar->execute();

        header("Location: /sistema_estoque/dashboard.php?msg=sucesso");



    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Editar Produto</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Nome:</label>
            <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($produto['nome']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Descrição:</label>
            <textarea name="descricao" class="form-control"><?= htmlspecialchars($produto['descricao']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Preço (R$):</label>
            <input type="text" name="preco" class="form-control" value="<?= number_format($produto['preco'], 2, ',', '.') ?>" required>
        </div>
        <div class="mb-3">
            <label>Quantidade em Estoque:</label>
            <input type="number" name="quantidade" class="form-control" value="<?= $produto['quantidade_estoque'] ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Salvar Alterações</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
