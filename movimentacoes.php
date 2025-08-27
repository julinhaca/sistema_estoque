<?php
session_start();
include 'db/conexao.php';

$sql = "SELECT m.id, p.nome AS produto, m.tipo, m.quantidade, u.nome AS usuario, m.observacao, m.data_movimentacao
        FROM movimentacoes m
        JOIN produtos p ON m.produto_id = p.id
        LEFT JOIN usuarios u ON m.usuario_id = u.id
        ORDER BY m.data_movimentacao DESC";
$result = $conexao->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Movimentações</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        h1 {
            font-weight: 600;
            color: #343a40;
        }
        .btn-custom {
            border-radius: 50px;
            font-weight: 500;
        }
        .table {
            border-radius: 12px;
            overflow: hidden;
        }
        thead {
            background-color: #4caf50;
            color: white;
        }
        .badge {
            font-size: 0.85rem;
            padding: 0.5em 0.75em;
            border-radius: 50px;
        }
        tbody tr:hover {
            background-color: #e9f5ec;
            transition: background-color 0.2s;
        }
    </style>
</head>
<body>

<div class="d-flex justify-content-between mb-3">
    <!-- Botão voltar para dashboard -->
    <a href="dashboard.php" class="btn btn-outline-secondary btn-custom">
        ⬅ Voltar para Dashboard
    </a>
</div>

<div class="container py-4">
    <h1 class="text-center mb-4">📦 Movimentações</h1>
    
    <div class="d-flex justify-content-end mb-3">
    <a href="relatorios/movimentacoes_pdf.php" target="_blank" class="btn btn-success btn-custom">
        ⬇ Baixar PDF
    </a>
</div>


    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Produto</th>
                    <th>Tipo</th>
                    <th>Quantidade</th>
                    <th>Usuário</th>
                    <th>Observação</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['produto']; ?></td>
                    <td>
                        <?php if (strtolower($row['tipo']) == 'entrada'): ?>
                            <span class="badge bg-primary">Entrada</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Saída</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $row['quantidade']; ?></td>
                    <td><?php echo $row['usuario']; ?></td>
                    <td><?php echo $row['observacao']; ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($row['data_movimentacao'])); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
