<?php
include('conexao.php');
include('verificaLogin.php');

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter os valores do formulário
    $codigo = $_POST['codigo']; // O código do produto
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'];
    $quantidade = $_POST['quantidade'];
    $disponibilidade = $_POST['disponibilidade'];

    // Verificar se o item já existe no banco de dados
    $check_sql = "SELECT id, quantidade FROM itens WHERE id = '$codigo'";
    $check_result = $conexao->query($check_sql);

    if ($check_result->num_rows > 0) {
        // O item já existe
        $item = $check_result->fetch_assoc();
        $quantidade_atual = $item['quantidade'];

        if ($quantidade_atual == 0) {
            // Permitir incrementar apenas se a quantidade atual for zero
            $novo_quantidade = $quantidade_atual + 1;
            $update_sql = "UPDATE itens SET quantidade = $novo_quantidade WHERE id = " . $item['id'];

            if ($conexao->query($update_sql) === TRUE) {
                echo "<script>alert('Item atualizado: quantidade incrementada para 1.');</script>";
            } else {
                echo "<script>alert('Erro ao atualizar item: " . $conexao->error . "');</script>";
            }
        } else {
            // Não permitir incremento se a quantidade for diferente de zero
            echo "<script>alert('O item já possui estoque. Não é possível adicionar mais unidades.');</script>";
        }
    } else {
        // O item não existe, então adicionar o item com os dados fornecidos
        $insert_sql = "INSERT INTO itens (id, descricao, categoria, quantidade, disponibilidade)
                       VALUES ('$codigo', '$descricao', '$categoria', $quantidade, $disponibilidade)";

        if ($conexao->query($insert_sql) === TRUE) {
            echo "<script>alert('Novo item adicionado com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao adicionar item: " . $conexao->error . "');</script>";
        }
    }
}

// Carregar as categorias para o campo de descrição (como anteriormente)
$itens_sql = "SELECT id, descricao FROM itens ORDER BY descricao ASC";
$itens_result = $conexao->query($itens_sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Adicionar Item</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
    <style>
        body {
            background: linear-gradient(to top left, #004A8D, #98c4ec);
        }
    </style>
</head>

<body>
    <section class="section">
        <div class="container">
            <h1 class="title has-text-white">Adicionar Item</h1>
            <form method="POST" action="adicionar_item.php">

                <!-- Campo de Código do Produto -->
                <div class="field">
                    <label class="label">Código do Produto</label>
                    <div class="control">
                        <input autofocus autocomplete="off" class="input" type="number" id="codigo" name="codigo" required>
                    </div>
                </div>

                <!-- Campo de Descrição -->
                <div class="field">
                    <label class="label">Descrição</label>
                    <div class="control">
                        <input class="input" type="text" id="descricao" name="descricao" readonly>
                    </div>
                </div>

                <!-- Campo de Categoria -->
                <div class="field">
                    <label class="label">Categoria</label>
                    <div class="control">
                        <input class="input" type="text" id="categoria" name="categoria" readonly>
                    </div>
                </div>

                <!-- Campo de Quantidade -->
                <div class="field">
                    <label class="label">Quantidade</label>
                    <div class="control">
                        <input class="input" type="number" id="quantidade" name="quantidade" readonly>
                    </div>
                </div>

                <!-- Campo de Disponibilidade -->
                <div class="field">
                    <label class="label">Disponibilidade</label>
                    <div class="control">
                        <input class="input" type="text" id="disponibilidade" name="disponibilidade" readonly>
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

    <script>
        // Quando o código do produto for digitado
        $('#codigo').on('input', function() {
            var codigo = $(this).val();

            // Verificar se o código tem pelo menos 4 caracteres
            if (codigo.length >= 4) {
                // Fazer a requisição AJAX
                $.get('buscar_item.php', {
                    codigo: codigo
                }, function(data) {
                    var produto = JSON.parse(data);

                    if (produto.erro) {
                        // Exibir mensagem se o produto não for encontrado
                        alert(produto.erro);
                    } else {
                        // Preencher os campos com as informações do produto
                        $('#descricao').val(produto.descricao);
                        $('#categoria').val(produto.nome_categoria); // Mostrar o nome da categoria
                        $('#quantidade').val(produto.quantidade);
                        $('#disponibilidade').val(produto.disponibilidade ? 'Sim' : 'Não');
                    }
                });
            } else {
                // Limpar os campos se o código for menor que 4 caracteres
                $('#descricao').val('');
                $('#categoria').val('');
                $('#quantidade').val('');
                $('#disponibilidade').val('');
            }
        });
    </script>
</body>

</html>
