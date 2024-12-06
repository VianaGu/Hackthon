<?php
include('conexao.php');

try {
    if ($conexao) {
        echo "<script>alert('Conexão com o banco de dados bem-sucedida!'); window.location.href='index.php';</script>";
    } else {
        throw new Exception("Falha ao conectar ao banco de dados.");
    }
} catch (Exception $e) {
    echo "<script>alert('Erro: {$e->getMessage()}'); window.location.href='index.php';</script>";
}
?>
