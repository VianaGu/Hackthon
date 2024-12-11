<?php
// Inicia uma sessão para controlar o estado do usuário
session_start();

// Verifica se a variável de sessão 'usuario' está definida
// Isso significa que o usuário está autenticado e logado
if(!$_SESSION['usuario']){
    // Se o usuário não estiver autenticado, redireciona para a página inicial (../)
    header('Location: ../Hackthon'); // Redireciona o usuário para a página raiz
    exit(); // Encerra a execução do script para garantir que o redirecionamento seja feito
}
?>