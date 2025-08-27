<?php
session_start();
require_once(__DIR__ . '/../db/conexao.php');
require_once(__DIR__ . '/../dompdf/autoload.inc.php');

use Dompdf\Dompdf;

$sql = "SELECT m.id, p.nome AS produto, m.tipo, m.quantidade, u.nome AS usuario, m.observacao, m.data_movimentacao
        FROM movimentacoes m
        JOIN produtos p ON m.produto_id = p.id
        LEFT JOIN usuarios u ON m.usuario_id = u.id
        ORDER BY m.data_movimentacao DESC";
$result = $conexao ->query($sql);

$html = '<h1>Relatório de Movimentações</h1>';
$html .= '<table border="1" cellpadding="8" cellspacing="0" width="100%">';
$html .= '<tr>
            <th>ID</th>
            <th>Produto</th>
            <th>Tipo</th>
            <th>Quantidade</th>
            <th>Usuário</th>
            <th>Observação</th>
            <th>Data</th>
          </tr>';

while($row = $result->fetch_assoc()) {
    $html .= '<tr>';
    $html .= '<td>'.$row['id'].'</td>';
    $html .= '<td>'.$row['produto'].'</td>';
    $html .= '<td>'.ucfirst($row['tipo']).'</td>';
    $html .= '<td>'.$row['quantidade'].'</td>';
    $html .= '<td>'.$row['usuario'].'</td>';
    $html .= '<td>'.$row['observacao'].'</td>';
    $html .= '<td>'.date('d/m/Y H:i', strtotime($row['data_movimentacao'])).'</td>';
    $html .= '</tr>';
}

$html .= '</table>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream('movimentacoes.pdf', array('Attachment' => 1));
?>
