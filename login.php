<?php
session_start();
include('conexao.php');

// Verifica se campos de texto estão vazios
if (empty($_POST['usuario']) || empty($_POST['senha'])) {
    header('location: index.php');
    exit();
}

// Captura os dados do campo de texto
$usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);
$senha = mysqli_real_escape_string($conexao, $_POST['senha']);

// Cria query para mandar no SQL
$query = "SELECT usuario FROM usuario WHERE usuario = '{$usuario}' AND senha = MD5('{$senha}')";

// Executa a query
$result = mysqli_query($conexao, $query);

// Verifica se a query foi executada com sucesso
if (!$result) {
    die('Erro na query: ' . mysqli_error($conexao));
}

// Retorna a quantidade de linhas retornada
$row = mysqli_num_rows($result);

if ($row == 1) {
    $_SESSION["usuario"] = $usuario;
    header('location: home/painel.php');
    exit();
} else {
    $_SESSION['nao autenticado'] = true;
    header('Location: index.php');
    exit();
}
?>
