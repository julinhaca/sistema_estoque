<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "sistema_estoque";

// Cria a conexão
$conexao = new mysqli($host, $usuario, $senha, $banco);

// Verifica se deu erro
if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}
?>