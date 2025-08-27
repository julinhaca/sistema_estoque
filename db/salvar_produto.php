<?php
include 'conexao.php'; // Caminho para o arquivo de conexão

$id = $_POST['id'] ?? '';
$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$preco = $_POST['preco'];
$quantidade = $_POST['quantidade_estoque'];
$categoria_id = $_POST['categoria_id'];

if ($id) {
    // Atualizar
    $stmt = $conexao->prepare("UPDATE produtos SET nome=?, descricao=?, preco=?, quantidade_estoque=?, categoria_id=? WHERE id=?");
    $stmt->bind_param("ssdiii", $nome, $descricao, $preco, $quantidade, $categoria_id, $id);
} else {
    // Inserir novo
    $stmt = $conexao->prepare("INSERT INTO produtos (nome, descricao, preco, quantidade_estoque, categoria_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdii", $nome, $descricao, $preco, $quantidade, $categoria_id);
}

if ($stmt->execute()) {
    header("Location: ../dashboard.php");
} else {
    echo "Erro ao salvar produto: " . $stmt->error;
}

$stmt->close();
$conexao->close();
