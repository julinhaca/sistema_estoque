<?php
session_start();
include 'conexao.php';

// Verifica se é edição
$id = $_GET['id'] ?? '';
$produto = ['nome' => '', 'descricao' => '', 'preco' => '', 'quantidade_estoque' => '', 'categoria_id' => ''];

if ($id) {
    $stmt = $conexao->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $produto = $resultado->fetch_assoc();
    $stmt->close();
}

// Busca categorias
$categorias = [];
$resultado = $conexao->query("SELECT * FROM categorias");
while ($row = $resultado->fetch_assoc()) {
    $categorias[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $id ? 'Editar Produto' : 'Cadastrar Produto' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="cadastrar_produto.css">
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0"><?= $id ? 'Editar Produto' : 'Cadastrar Produto' ?></h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="salvar_produto.php">
                        <input type="hidden" name="id" value="<?= $id ?>">

                        <div class="mb-3">
                            <label class="form-label">Nome:</label>
                            <input type="text" class="form-control" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descrição:</label>
                            <textarea class="form-control" name="descricao"><?= htmlspecialchars($produto['descricao']) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Preço:</label>
                            <input type="number" class="form-control" name="preco" step="0.01" value="<?= htmlspecialchars($produto['preco']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Quantidade em Estoque:</label>
                            <input type="number" class="form-control" name="quantidade_estoque" value="<?= htmlspecialchars($produto['quantidade_estoque']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Categoria:</label>
                            <select class="form-select" name="categoria_id" required>
                                <option value="">Selecione</option>
                                <?php foreach ($categorias as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= $produto['categoria_id'] == $cat['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                        <a href="../dashboard.php" class="btn btn-secondary">Voltar</a>
                            <button type="submit" class="btn btn-success">Salvar Produto</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

