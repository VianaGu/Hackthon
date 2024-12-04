<?php
session_start();
include('verificaLogin.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produto</title>
    <!-- Importação do Bulma -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <!-- Estilo personalizado -->
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
            background: linear-gradient(135deg, #00c4a7, #0072ff);
            color: #fff;
            font-weight: bold;
            border: none;
        }

        .button.is-fullwidth:hover {
            background: linear-gradient(135deg, #0072ff, #00c4a7);
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
                            <form action="cadastrar_produto.php" method="POST">
                                <div class="field">
                                    <label class="label">Descrição do Produto</label>
                                    <div class="control">
                                        <input type="text" name="descricao" class="input" placeholder="Ex: Notebook Gamer" required>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Código de Item</label>
                                    <div class="control">
                                        <input type="text" name="codigo_item" class="input" placeholder="Ex: 12345" required>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Categoria</label>
                                    <div class="control">
                                        <input type="text" name="categoria" class="input" placeholder="Ex: Eletrônicos" required>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Quantidade</label>
                                    <div class="control">
                                        <input type="number" name="quantidade" class="input" placeholder="Ex: 10" min="0" required>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Disponibilidade</label>
                                    <div class="control">
                                        <div class="select is-fullwidth">
                                            <select name="disponibilidade" required>
                                                <option value="" disabled selected>Selecione...</option>
                                                <option value="Disponível">Disponível</option>
                                                <option value="Indisponível">Indisponível</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <button type="submit" class="button is-fullwidth is-large">Cadastrar Produto</button>
                                </div>
                            </form>
                            <div class="has-text-centered">
                                <a href="menu.php" class="button is-small is-light">Voltar ao Menu</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
