<?php
session_start();
include 'db/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if (!$conexao) {
    die("Erro na conexão: " . mysqli_connect_error());
}

// Obter categorias para o dropdown
$sql_categorias = "SELECT c.id, c.nome, COUNT(p.id) AS total 
                   FROM categorias c 
                   LEFT JOIN produtos p ON p.categoria_id = c.id 
                   GROUP BY c.id, c.nome";
$resultado_categorias = mysqli_query($conexao, $sql_categorias);

// Filtros
$categoria_id = isset($_GET['categoria']) ? intval($_GET['categoria']) : 0;
$busca = isset($_GET['busca']) ? trim($_GET['busca']) : "";

// Construir a query base
$sql_produtos = "SELECT * FROM produtos WHERE 1";

// Adicionar filtro de categoria, se houver
if ($categoria_id > 0) {
    $sql_produtos .= " AND categoria_id = $categoria_id";
}

// Adicionar filtro de busca por nome, se houver
if (!empty($busca)) {
    $busca_escapada = mysqli_real_escape_string($conexao, $busca);
    $sql_produtos .= " AND nome LIKE '%$busca_escapada%'";
}

// Executar a consulta
$resultado_produtos = mysqli_query($conexao, $sql_produtos);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Menu - Sistema de Estoque</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS do Dashboard Embutido -->
    <style>
    /* Fundo do dashboard */
    body {
        background: linear-gradient(135deg, #a8dadc, #f0f8ff);
        font-family: 'Roboto', sans-serif;
    }

    /* Navbar customizada */
    .navbar {
        background-color: #1d3557 !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    /* Botão Cadastrar Produto */
.navbar .btn-success {
    background-color: #90ee90; /* verde claro */
    border-color: #90ee90;
    color: #000; /* texto preto para contraste */
    transition: 0.3s;
}

.navbar .btn-success:hover {
    background-color: #76c776; /* verde um pouco mais escuro no hover */
    border-color: #76c776;
}

/* Botão Movimentações */
.navbar .btn-info {
    background-color: #fff176; /* amarelo claro */
    border-color: #fff176;
    color: #000; /* texto preto */
    transition: 0.3s;
}

.navbar .btn-info:hover {
    background-color: #ffee58; /* hover mais forte */
    border-color: #ffee58;
}

/* Dropdown Categorias */
.dropdown-toggle {
    background-color: #fff; /* botão branco */
    color: #000; /* texto preto */
    border: 1px solid #ccc;
}

.dropdown-menu {
    background-color: #fff; /* menu branco */
    color: #000; /* texto preto */
}

.dropdown-item {
    color: #000; /* texto preto */
}

.dropdown-item:hover {
    background-color: #e0e0e0; /* hover cinza claro */
}


    /* Container principal */
    .container {
        background: rgba(25, 42, 86, 0.85);
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
        color: white;
        margin-top: 2rem;
    }

    /* Tabela customizada */
    .table {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
        border-radius: 10px;
        overflow: hidden;
    }

    .table thead {
        background-color: #457b9d;
        color: white;
    }

    .table tbody tr:hover {
        background-color: rgba(69, 123, 157, 0.5);
        transition: 0.3s;
    }

    /* Inputs de busca */
    .form-control {
        background-color: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .form-control:focus {
        background-color: rgba(255, 255, 255, 0.3);
        color: white;
        box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.2);
        outline: none;
    }

    /* Suavização para botões da navbar e dropdown */
    .navbar .btn, .dropdown-item {
        border-radius: 6px;
    }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark px-4 py-3">
        <a class="navbar-brand fw-bold text-white" href="dashboard.php">Estoque</a>

        <div class="collapse navbar-collapse">
            <form class="d-flex ms-auto me-3" method="GET" action="dashboard.php">
                <input class="form-control me-2" type="search" name="busca" placeholder="Buscar produto">
                <button class="btn btn-light" type="submit">Buscar</button>
            </form>

            <!-- Dropdown Categorias -->
            <div class="dropdown me-3">
                <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Categorias
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <?php while ($cat = mysqli_fetch_assoc($resultado_categorias)) { ?>
                        <li>
                            <a class="dropdown-item" href="dashboard.php?categoria=<?= $cat['id'] ?>">
                                <?= htmlspecialchars($cat['nome']) ?> (<?= $cat['total'] ?>)
                            </a>
                        </li>
                    <?php } ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="dashboard.php">Todas</a></li>
                </ul>
            </div>

            <!-- Botão PDF -->
            <?php if (isset($_GET['categoria']) && is_numeric($_GET['categoria'])): ?>
                <a href="relatorios/gerar_pdf.php?categoria=<?= intval($_GET['categoria']) ?>" class="btn btn-warning me-2">
                    Baixar PDF da Categoria
                </a>
            <?php endif; ?>

            <!-- Botão Cadastrar Produto -->
            <a href="db/cadastrar_produto.php" class="btn btn-success me-2">
                + Cadastrar Produto
            </a>

            <!-- Botão Movimentações -->
            <a href="movimentacoes.php" class="btn btn-info">
                Movimentações
            </a>
        </div>
    </nav>

    <div class="container mt-4">
        <h3>Lista de Produtos</h3>
        <?php if (!empty($busca)): ?>
            <p class="text-muted">Resultados da busca por: <strong><?= htmlspecialchars($busca) ?></strong></p>
        <?php endif; ?>

        <?php if (mysqli_num_rows($resultado_produtos) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Preço (R$)</th>
                            <th>Estoque</th>
                            <th>Criado em</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($produto = mysqli_fetch_assoc($resultado_produtos)) { ?>
                            <tr>
                                <td><?= $produto['id'] ?></td>
                                <td><?= htmlspecialchars($produto['nome']) ?></td>
                                <td><?= htmlspecialchars($produto['descricao']) ?></td>
                                <td><?= number_format($produto['preco'], 2, ',', '.') ?></td>
                                <td><?= $produto['quantidade_estoque'] ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($produto['criado_em'])) ?></td>
                                <td>
                                    <a href="db/editar_produto.php?id=<?= $produto['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
                                    <a href="db/excluir_produto.php?id=<?= $produto['id'] ?>" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Tem certeza que deseja excluir este produto?');">Excluir</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>Nenhum produto encontrado.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get("msg") === "sucesso") {
                const modal = new bootstrap.Modal(document.getElementById('modalSucesso'));
                modal.show();
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        });
    </script>

    <!-- Modal de Sucesso -->
    <div class="modal fade" id="modalSucesso" tabindex="-1" aria-labelledby="modalSucessoLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="modalSucessoLabel">Sucesso</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body">
            Produto alterado com sucesso!
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>

</body>
</html>

