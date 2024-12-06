<?php
include('conexao.php');
include('verificaLogin.php');

// Query para buscar os itens com o nome da categoria e imagem
$sql = "
SELECT 
    itens.id, 
    itens.descricao, 
    categoria.categoria AS nome_categoria, 
    itens.quantidade, 
    itens.disponibilidade,
    itens.imagem
FROM itens
INNER JOIN categoria ON itens.categoria = categoria.id";
$result = $conexao->query($sql);
?>
<style>
    body {
        background: linear-gradient(to top left, #004A8D, #98c4ec);
    }

    .item-image {
        max-width: 100px;
        max-height: 100px;
        object-fit: contain;
    }
</style>
<!DOCTYPE html>
<html>

<head>
    <title>Lista de Itens</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
</head>

<body>
    <section class="section">
        <div class="container">
            <h1 class="title has-text-white">Lista de Itens</h1>

            <!-- Botão de Adicionar Novo Item -->
            <a href="adicionar_item.php" class="button is-primary mb-4">Devolver Item</a>
             <!-- Botão de Adicionar Novo Item -->
             <a href="historico.php" class="button is-primary mb-4">Histórico</a>
             <!-- Botão de Adicionar Novo Item -->
             <a href="HomePage/index.html" class="button is-primary mb-4">Home</a>

            <!-- Tabela com Itens -->
            <table class="table is-striped is-fullwidth">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Quantidade</th>
                        <th>Disponibilidade</th>
                        <th>Imagem</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Verifica a disponibilidade com base na quantidade
                            $disponibilidade = $row["quantidade"] > 0 ? "Disponível" : "Indisponível";

                            echo "<tr>";
                            echo "<td>" . str_pad($row["id"], 4, "0", STR_PAD_LEFT) . "</td>"; // Código formatado com 4 dígitos
                            echo "<td>" . htmlspecialchars($row["descricao"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["nome_categoria"]) . "</td>"; // Nome da categoria
                            echo "<td>" . htmlspecialchars($row["quantidade"]) . "</td>";
                            echo "<td>" . $disponibilidade . "</td>"; // Disponibilidade com base na quantidade
                            echo "<td>";
                            if (!empty($row["imagem"])) {
                                echo "<img src='" . htmlspecialchars($row["imagem"]) . "' alt='Imagem do item' class='item-image'>";
                            } else {
                                echo "Sem imagem";
                            }
                            echo "</td>";
                            echo "<td>
                            <a href='retirar_item.php?id=" . $row["id"] . "' class='button is-danger is-small'>Retirar</a>
                          </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Nenhum item encontrado</td></tr>";
                    }
                    $conexao->close();
                    ?>
                </tbody>
            </table>
        </div>
        
    </section>
    
</body>

</html>
