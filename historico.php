<?php
include('conexao.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Histórico de Aluguel</title>
    <!-- Link para o Bulma CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        section {
            background: linear-gradient(to top left, #004A8D, #98c4ec);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .box {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        h1.title {
            color: #ffffff;
        }
    </style>
</head>
<body>
    <section>
        <div class="container">
            <h1 class="title has-text-centered">Consulta de Histórico de Aluguel</h1>
            <div class="box">
                <!-- Formulário para receber o código do item -->
                <form method="POST">
                    <div class="field">
                        <label class="label" for="codigo_item">Digite o código do item:</label>
                        <div class="control">
                            <input 
                                class="input" 
                                type="text" 
                                id="codigo_item" 
                                name="codigo_item" 
                                placeholder="Ex.: 123" 
                                required>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <button class="button is-link is-fullwidth" type="submit">Consultar</button>
                        </div>
                    </div>
                </form>
            </div>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codigo_item'])) {
                $codigo_item = $_POST['codigo_item'];

                $sql_item = "SELECT id FROM itens WHERE id = ?";
                if ($stmt_item = $conexao->prepare($sql_item)) {
                    $stmt_item->bind_param("i", $codigo_item);
                    $stmt_item->execute();
                    $result_item = $stmt_item->get_result();

                    if ($result_item->num_rows > 0) {
                        $item = $result_item->fetch_assoc();
                        $id_item = $item['id'];

                        $sql_historico = "
                            SELECT u.usuario, h.data_retirada
                            FROM historico h
                            JOIN usuario u ON h.id_Usuario = u.id
                            WHERE h.id_Item = ?
                        ";

                        if ($stmt_historico = $conexao->prepare($sql_historico)) {
                            $stmt_historico->bind_param("i", $id_item);
                            $stmt_historico->execute();
                            $result_historico = $stmt_historico->get_result();

                            if ($result_historico->num_rows > 0) {
                                echo "<div class='box'>";
                                echo "<h3 class='subtitle'>Usuários que alugaram o item com código <strong>$codigo_item</strong>:</h3>";
                                echo "<table class='table is-striped is-hoverable is-fullwidth'>";
                                echo "<thead><tr><th>Usuário</th><th>Data de Retirada</th></tr></thead><tbody>";

                                while ($row = $result_historico->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row["usuario"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["data_retirada"]) . "</td>";
                                    echo "</tr>";
                                }

                                echo "</tbody></table>";
                                echo "</div>";
                            } else {
                                echo "<div class='notification is-warning'>Nenhum usuário alugou o item com código <strong>$codigo_item</strong>.</div>";
                            }

                            $stmt_historico->close();
                        } else {
                            echo "<div class='notification is-danger'>Erro na consulta de histórico: " . $conexao->error . "</div>";
                        }
                    } else {
                        echo "<div class='notification is-warning'>Nenhum item encontrado com o código <strong>$codigo_item</strong>.</div>";
                    }

                    $stmt_item->close();
                } else {
                    echo "<div class='notification is-danger'>Erro na consulta do item: " . $conexao->error . "</div>";
                }

                $conexao->close();
            }
            ?>
        </div>
    </section>
</body>
</html>
