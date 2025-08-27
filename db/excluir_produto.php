<?php
session_start();
include 'conexao.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $conexao->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: dashboard.php");
exit();
