<?php
include('conexao.php');

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter os valores do formulário
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'];
    $quantidade = $_POST['quantidade'];
    $disponibilidade = $_POST['disponibilidade'];

    // Validar os dados antes de inserir
    if (empty($descricao) || empty($categoria) || empty($quantidade)) {
        echo "Por favor, preencha todos os campos.";
    } else {
        // Verificar se o item já existe no banco de dados
        $check_sql = "SELECT id, quantidade FROM itens WHERE descricao = '$descricao'";
        $check_result = $conexao->query($check_sql);

        if ($check_result->num_rows > 0) {
            // O item já existe, vamos atualizar a quantidade
            $item = $check_result->fetch_assoc();
            $novo_quantidade = $item['quantidade'] + $quantidade; // Incrementar a quantidade
            $update_sql = "UPDATE itens SET quantidade = $novo_quantidade WHERE id = " . $item['id'];

            if ($conexao->query($update_sql) === TRUE) {
                echo "Quantidade do item atualizada com sucesso!";
            } else {
                echo "Erro ao atualizar item: " . $conexao->error;
            }
        } else {
            // O item não existe, então adicionar o item com a quantidade fornecida
            $insert_sql = "INSERT INTO itens (descricao, categoria, quantidade, disponibilidade)
                           VALUES ('$descricao', $categoria, $quantidade, $disponibilidade)";

            if ($conexao->query($insert_sql) === TRUE) {
                echo "Novo item adicionado com sucesso!";
            } else {
                echo "Erro ao adicionar item: " . $conexao->error;
            }
        }
    }
}

// Carregar os itens existentes para o campo de descrição
$itens_sql = "SELECT id, descricao FROM itens ORDER BY descricao ASC";
$itens_result = $conexao->query($itens_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Item</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
</head>
<body>
    <section class="section">
        <div class="container">
            <h1 class="title">Adicionar Item</h1>
            <form method="POST" action="adicionar_item.php">
                <!-- Campo de Descrição com Produtos Existentes -->
                <div class="field">
                    <label class="label">Descrição</label>
                    <div class="control">
                        <select class="input" name="descricao" required>
                            <option value="">Escolha um produto existente</option>
                            <?php
                            // Verificar se existem itens cadastrados
                            if ($itens_result->num_rows > 0) {
                                while ($item_row = $itens_result->fetch_assoc()) {
                                    echo "<option value='" . $item_row['descricao'] . "'>" . htmlspecialchars($item_row['descricao']) . "</option>";
                                }
                            } else {
                                echo "<option value=''>Nenhum produto encontrado</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Carregar as categorias (relacionada ao produto selecionado) -->
                <div class="field">
                    <label class="label">Categoria</label>
                    <div class="control">
                        <select class="input" name="categoria" required>
                            <option value="">Selecione uma categoria</option>
                            <?php
                            // Carregar as categorias do banco de dados
                            $categoria_sql = "SELECT id, categoria FROM categoria ORDER BY categoria ASC";
                            $categoria_result = $conexao->query($categoria_sql);
                            
                            if ($categoria_result->num_rows > 0) {
                                while ($categoria_row = $categoria_result->fetch_assoc()) {
                                    echo "<option value='" . $categoria_row['id'] . "'>" . htmlspecialchars($categoria_row['categoria']) . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Campo de Quantidade -->
                <div class="field">
                    <label class="label">Quantidade</label>
                    <div class="control">
                        <input class="input" type="number" name="quantidade" min="1" required>
                    </div>
                </div>

                <!-- Campo de Disponibilidade -->
                <div class="field">
                    <label class="label">Disponibilidade</label>
                    <div class="control">
                        <div class="select">
                            <select name="disponibilidade" required>
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <button class="button is-primary" type="submit">Adicionar Item</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</body>
</html>
