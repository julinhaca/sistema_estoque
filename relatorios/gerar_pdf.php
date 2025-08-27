<?php
require_once __DIR__ . '/../dompdf/autoload.inc.php';

use Dompdf\Dompdf;

include_once __DIR__ . '/../db/conexao.php';


if (!isset($_GET['categoria']) || !is_numeric($_GET['categoria'])) {
    die("Categoria inválida.");
}

$categoria_id = intval($_GET['categoria']);

// Buscar nome da categoria
$sql_categoria = "SELECT nome FROM categorias WHERE id = $categoria_id";
$res_categoria = mysqli_query($conexao, $sql_categoria);
if (mysqli_num_rows($res_categoria) == 0) {
    die("Categoria não encontrada.");
}
$categoria_nome = mysqli_fetch_assoc($res_categoria)['nome'];

// Buscar produtos da categoria
$sql_produtos = "SELECT * FROM produtos WHERE categoria_id = $categoria_id";
$res_produtos = mysqli_query($conexao, $sql_produtos);

// Montar HTML
$html = "
    <h2 style='text-align: center;'>Relatório da Categoria: {$categoria_nome}</h2>
    <table border='1' width='100%' cellpadding='8' cellspacing='0'>
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Estoque</th>
            </tr>
        </thead>
        <tbody>
";

while ($produto = mysqli_fetch_assoc($res_produtos)) {
    $html .= "<tr>
        <td>{$produto['id']}</td>
        <td>" . htmlspecialchars($produto['nome']) . "</td>
        <td>" . htmlspecialchars($produto['descricao']) . "</td>
        <td>R$ " . number_format($produto['preco'], 2, ',', '.') . "</td>
        <td>{$produto['quantidade_estoque']}</td>
    </tr>";
}

$html .= "</tbody></table>";

// Gerar PDF com Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("relatorio_{$categoria_nome}.pdf", ["Attachment" => false]);
exit;
?>

