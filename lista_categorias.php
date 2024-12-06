<?php
include('conexao.php'); // Inclui a conexão com o banco de dados
include('verificaLogin.php'); // Verifica se o usuário está logado

// Query para buscar todas as categorias
$sql = "SELECT * FROM categoria";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Lista de Categorias</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
</head>

<body>
    <section class="section">
        <div class="container">
            <h1 class="title">Categorias Cadastradas</h1>

            <!-- Tabela de Categorias -->
            <table class="table is-striped is-fullwidth">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Categoria</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . htmlspecialchars($row["categoria"]) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>Nenhuma categoria encontrada</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Link para voltar ao cadastro -->
            <a href="cadastro_categoria.php" class="button is-link">Cadastrar Nova Categoria</a>
        </div>
    </section>
</body>

</html>
