<?php
include('verificaLogin.php')
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Histórico de Retiradas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
    <style>
        :root{
            margin: 0;
            padding: 0;
        }
        body {
            background: linear-gradient(to top left, #004A8D, #98c4ec);
            height: 100rem;
        }

        .container {
            margin-top: 50px;
        }

        .button-container {
            margin-top: 20px;
        }

        .result-container {
            margin-top: 20px;
        }

        h2 {
            color: white;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .notification {
            background-color: #f7f7f7;
            border-radius: 8px;
            padding: 10px;
        }

        .result-container h3 {
            color: #00d1b2;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="title has-text-white">Consultar Histórico de Retiradas</h2>

        <!-- Formulário para receber o código do item -->
        <div class="form-container">
            <form method="POST">
                <div class="field">
                    <label class="label has-text-dark">Digite o código do item:</label>
                    <div class="control">
                        <input type="text" id="codigo_item" name="codigo_item" class="input" required placeholder="Código do item">
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-primary">Consultar</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="result-container">
            <?php
            include('conexao.php');
            // Verificar se o formulário foi enviado
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codigo_item'])) {

                // Pegar o código do item enviado via POST
                $codigo_item = $_POST['codigo_item'];

                // Consulta SQL para buscar o id do item com base no código
                $sql_item = "SELECT id FROM itens WHERE id = ?";
                if ($stmt_item = $conexao->prepare($sql_item)) {
                    $stmt_item->bind_param("s", $codigo_item); // "s" para string
                    $stmt_item->execute();
                    $result_item = $stmt_item->get_result();

                    if ($result_item->num_rows > 0) {
                        // Obter o id do item
                        $item = $result_item->fetch_assoc();
                        $id_item = $item['id'];

                        // Consulta SQL para buscar os detalhes das retiradas em ordem decrescente pela data de retirada
                        $sql_retiradas = "
                            SELECT r.item_id, r.nome, r.endereco, r.telefone, r.data_retirada, r.data_prevista_entrega
                            FROM retiradas r
                            WHERE r.item_id = ?
                            ORDER BY r.data_retirada DESC
                        ";

                        if ($stmt_retiradas = $conexao->prepare($sql_retiradas)) {
                            $stmt_retiradas->bind_param("i", $id_item); // "i" para integer
                            $stmt_retiradas->execute();
                            $result_retiradas = $stmt_retiradas->get_result();

                            // Exibir os resultados
                            if ($result_retiradas->num_rows > 0) {
                                echo "<div class='notification is-info'>";
                                echo "<h3>Histórico de retiradas do item com código $codigo_item:</h3>";
                                echo "<div class='content'>";

                                // Exibir cada registro de retirada
                                while ($row = $result_retiradas->fetch_assoc()) {
                                    echo "<p><strong>ID do Item:</strong> " . $row["item_id"] . "</p>";
                                    echo "<p><strong>Nome do Responsável:</strong> " . $row["nome"] . "</p>";
                                    echo "<p><strong>Endereço:</strong> " . $row["endereco"] . "</p>";
                                    echo "<p><strong>Telefone:</strong> " . $row["telefone"] . "</p>";
                                    echo "<p><strong>Data de Retirada:</strong> " . $row["data_retirada"] . "</p>";
                                    echo "<p><strong>Data Prevista de Devolução:</strong> " . $row["data_prevista_entrega"] . "</p><hr>";
                                }

                                echo "</div></div>";
                            } else {
                                echo "<div class='notification is-warning'>Nenhum histórico encontrado para o item com código $codigo_item.</div>";
                            }

                            $stmt_retiradas->close();
                        } else {
                            echo "<div class='notification is-danger'>Erro na consulta de retiradas: " . $conexao->error . "</div>";
                        }
                    } else {
                        echo "<div class='notification is-warning'>Nenhum item encontrado com o código $codigo_item.</div>";
                    }

                    $stmt_item->close();
                } else {
                    echo "<div class='notification is-danger'>Erro na consulta do item: " . $conexao->error . "</div>";
                }

                $conexao->close();
            }
            ?>
        </div>

        <!-- Botão para voltar à lista de itens -->
        <div class="button-container">
            <a href="Tabelaitens.php" class="button is-link">Voltar para a Lista de Itens</a>
        </div>
    </div>
</body>

</html>
