<?php
session_start();
?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="css/NavBar.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="node_modules/bulma//css/bulma.min.css" />
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body>
    <section class="hero is-success is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <h3 class="title">Login</h3>
                    <?php 
                        if(isset($_SESSION['nao autenticado'])):
                    ?>
                    <div class="notification is-warning">
                      <p>ERRO: Usuário ou senha inválidos.</p>
                    </div>
                    <?php
                    endif;
                    unset($_SESSION['nao_autenticado']);
                    ?>
                    <div class="box">
                        <form action="login.php" method="POST">
                            <div class="field">
                                <div class="control">
                                    <input id="usuario" name="usuario" autocomplete="off" 
                                    name="text" class="input is-large" placeholder="Seu usuário" >
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input id="senha" name="senha" autocomplete="off" class="input is-large" type="password" placeholder="Sua senha">
                                </div>
                            </div>
                            <button type="submit" class="button is-block is-link is-large is-fullwidth">Entrar</button>
                        </form>
                    </div>
                    <h1 class="title"><a href="cadastro.php">Cadastrar</a></h1>
                </div>
            </div>
        </div>
    </section>

<script>
    // Função para lidar com a tecla Enter
    function handleEnterKeyPress(event) {
        // Verifica se a tecla pressionada é Enter
        if (event.keyCode === 13) {
            // Previne o comportamento padrão do formulário (submit)
            event.preventDefault();

            // Obtém o ID do elemento atual (campo focado)
            var currentElementId = event.target.id;

            // Verifica qual campo está focado atualmente e move para o próximo
            if (currentElementId === "usuario") {
                document.getElementById("senha").focus(); // Move para o campo de senha
            } else if (currentElementId === "senha") {
                // Se o campo de senha está focado, submete o formulário
                event.target.closest("form").submit();
            }
        }
    }

    // Adiciona um listener para o evento keydown nos campos de entrada
    document.getElementById("usuario").addEventListener("keydown", handleEnterKeyPress);
    document.getElementById("senha").addEventListener("keydown", handleEnterKeyPress);
</script>
</body>

</html>