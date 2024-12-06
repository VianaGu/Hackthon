<?php
session_start();
include('conexao.php'); // Conexão habilitada
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #00c4a7, #0072ff);
            color: #fff;
            font-family: 'Open Sans', sans-serif;
        }

        .box {
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            background: #fff;
            color: #333;
        }

        .title {
            color: #fff;
        }

        .button.is-fullwidth {
            background: linear-gradient(135deg, #0072ff, #00c4a7);
            color: #fff;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        }

        .button.is-fullwidth:hover {
            transform: scale(1.05);
            box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #00c4a7, #0072ff);
            color: #fff;
        }

        .is-success {
            background-color: #00c4a7 !important;
        }

        .hero {
            padding-top: 2rem;
        }
    </style>
</head>

<body>
    <section class="hero is-fullheight">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-centered">
                    <div class="column is-5">
                        <h1 class="title has-text-centered">Cadastro de Produto</h1>
                        <?php
                        if (isset($_SESSION['erro'])):
                        ?>
                            <div class="notification is-danger">
                                <p><?php echo $_SESSION['erro']; ?></p>
                            </div>
                        <?php
                        unset($_SESSION['erro']);
                        endif;
                        ?>

                        <div class="box">
                            <form action="cadastrar_produto.php" method="POST" enctype="multipart/form-data">
                                <!-- Botão de teste de conexão -->
                                <div class="field">
                                    <a href="testar_conexao.php" class="button is-fullwidth is-danger">Testar Conexão com o Banco</a>
                                </div>
                                <!-- Outros campos -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
