<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="node_modules/bulma/css/bulma.min.css" />
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" href="css/NavBar.css">
</head>

<body>
    <section class="hero is-success is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <h3 class="title">Cadastro</h3>
                    <?php
                    if (isset($_SESSION['ja_cadastro'])):
                    ?>
                        <div class="notification is-warning">
                            <p>Esse Usuário já existe.</p>
                        </div>
                    <?php
                    endif;
                    unset($_SESSION['ja_cadastro']);
                    ?>
                    <?php
                    if (isset($_SESSION['emailInvalido'])):
                    ?>
                        <div class="notification is-danger">
                            <p>E-mail Inválido.</p>
                        </div>
                    <?php
                    endif;
                    unset($_SESSION['emailInvalido']);
                    ?>
                    <?php
                    if (isset($_SESSION['cadastrado'])):
                    ?>
                        <div class="notification is-success is-light">
                            <p>Usuário cadastrado com sucesso.</p>
                        </div>
                    <?php
                    endif;
                    unset($_SESSION['cadastrado']);
                    ?>
                    <div class="box">
                        <form action="cadastrar.php" method="POST">
                            <div class="field">
                                <div class="control">
                                    <input id="email" name="email" autocomplete="off" type="e-mail" class="input is-large" placeholder="Seu melhor e-mail" autofocus="">
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input id="usuario" name="usuario" autocomplete="off" class="input is-large" placeholder="Seu usuário" autofocus="">
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input id="celular" name="celular" autocomplete="off" class="input is-large" placeholder="(xx) xxxxx-xxxx" oninput="formatarCelular(this)">
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input id="dataNas" name="dataNas" autocomplete="off" class="input is-large" placeholder="dd/mm/aaaa" oninput="formatarData(this)">
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input id="cpf" name="cpf" autocomplete="off" class="input is-large" placeholder="CPF" oninput="formatarCPF(this)">
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input id="rua" name="rua" autocomplete="off" class="input is-large" placeholder="Qual seu endereço?(Rua)">
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input id="ruaNum" name="ruaNum" autocomplete="off" class="input is-large" placeholder="Número:">
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input id="complemento" name="complemento" autocomplete="off" class="input is-large" placeholder="Complemento:">
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input id="senha" name="senha" class="input is-large" type="password" placeholder="Sua senha">
                                </div>
                            </div>
                            <button type="submit" class="button is-block is-link is-large is-fullwidth">Cadastrar</button>
                        </form>
                        <script>
                            function formatarCelular(input) {
                                // Remove todos os caracteres não numéricos
                                let numero = input.value.replace(/\D/g, '');

                                // Adiciona parênteses e hífen conforme a digitação
                                if (numero.length > 0) {
                                    numero = '(' + numero;
                                }
                                if (numero.length > 3) {
                                    numero = numero.slice(0, 3) + ') ' + numero.slice(3);
                                }
                                if (numero.length > 10) {
                                    numero = numero.slice(0, 10) + '-' + numero.slice(10);
                                }

                                // Atualiza o valor do input
                                input.value = numero;
                            }

                            function formatarData(input) {
                                // Remove todos os caracteres não numéricos
                                let data = input.value.replace(/\D/g, '');

                                // Adiciona barras conforme a digitação
                                if (data.length > 2) {
                                    data = data.slice(0, 2) + '/' + data.slice(2);
                                }
                                if (data.length > 5) {
                                    data = data.slice(0, 5) + '/' + data.slice(5);
                                }

                                // Atualiza o valor do input
                                input.value = data;
                            }

                            function formatarCPF(input) {
                                // Remove todos os caracteres não numéricos
                                let cpf = input.value.replace(/\D/g, '');

                                // Adiciona pontos e hífen conforme a digitação
                                if (cpf.length > 3) {
                                    cpf = cpf.slice(0, 3) + '.' + cpf.slice(3);
                                }
                                if (cpf.length > 7) {
                                    cpf = cpf.slice(0, 7) + '.' + cpf.slice(7);
                                }
                                if (cpf.length > 11) {
                                    cpf = cpf.slice(0, 11) + '-' + cpf.slice(11);
                                }

                                // Atualiza o valor do input
                                input.value = cpf;
                            }
                        </script>
                    </div>
                    <h1 class="title"><a href="index.php">Login</a></h1>
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
                if (currentElementId === "email") {
                    document.getElementById("usuario").focus();
                } else if (currentElementId === "usuario") {
                    document.getElementById("celular").focus();
                } else if (currentElementId === "celular") {
                    document.getElementById("dataNas").focus();
                } else if (currentElementId === "dataNas") {
                    document.getElementById("cpf").focus();
                } else if (currentElementId === "cpf") {
                    document.getElementById("rua").focus();
                } else if (currentElementId === "rua") {
                    document.getElementById("ruaNum").focus();
                } else if (currentElementId === "ruaNum") {
                    document.getElementById("complemento").focus();
                } else if (currentElementId === "complemento") {
                    document.getElementById("senha").focus();
                } else if (currentElementId === "senha") {
                    // Se o campo de senha está focado, submete o formulário
                    event.target.closest("form").submit();
                }
            }
        }

        // Adiciona um listener para o evento keydown nos campos de entrada
        document.getElementById("email").addEventListener("keydown", handleEnterKeyPress);
        document.getElementById("usuario").addEventListener("keydown", handleEnterKeyPress);
        document.getElementById("celular").addEventListener("keydown", handleEnterKeyPress);
        document.getElementById("dataNas").addEventListener("keydown", handleEnterKeyPress);
        document.getElementById("cpf").addEventListener("keydown", handleEnterKeyPress);
        document.getElementById("rua").addEventListener("keydown", handleEnterKeyPress);
        document.getElementById("ruaNum").addEventListener("keydown", handleEnterKeyPress);
        document.getElementById("complemento").addEventListener("keydown", handleEnterKeyPress);
        document.getElementById("senha").addEventListener("keydown", handleEnterKeyPress);
    </script>

</body>

</html>
