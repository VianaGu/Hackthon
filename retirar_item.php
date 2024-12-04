<?php
include('conexao.php');

// Verifica se o ID foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];

    // Query para reduzir a quantidade e atualizar a disponibilidade
    $sql = "
    UPDATE itens 
    SET quantidade = GREATEST(quantidade - 1, 0), 
        disponibilidade = IF(quantidade - 1 <= 0, false, true)
    WHERE id = $id";

    if ($conexao->query($sql) === TRUE) {
        echo "Item retirado com sucesso!";
    } else {
        echo "Erro ao retirar o item: " . $conexao->error;
    }

    $conexao->close();

    // Redireciona de volta para a página principal
    header("Location: Tabelaitens.php");
    exit();
} else {
    echo "Requisição inválida.";
}
?>
