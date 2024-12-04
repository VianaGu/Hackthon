<?php
include('conexao.php');
include('verificaLogin.php');

// Verifica se o ID foi passado via GET
if (isset($_GET['id'])) {
    $id_item = (int)$_GET['id'];

    // Consulta para obter os detalhes do item (como nome, quantidade, categoria, etc.)
    $sql = "SELECT descricao, categoria FROM itens WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_item);
    $stmt->execute();
    $stmt->bind_result($descricao, $categoria);
    $stmt->fetch();
    $stmt->close();

    if (!$descricao) {
        echo "Item não encontrado!";
        exit();
    }
} else {
    echo "ID do item não fornecido!";
    exit();
}

// Processa a retirada quando o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome']) && isset($_POST['endereco']) && isset($_POST['telefone'])) {
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];

    // Verifica a quantidade do item
    $sql_check = "SELECT quantidade FROM itens WHERE id = ?";
    $stmt_check = $conexao->prepare($sql_check);
    $stmt_check->bind_param("i", $id_item);
    $stmt_check->execute();
    $stmt_check->bind_result($quantidade);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($quantidade <= 0) {
        echo "Este item não está disponível para retirada.";
    } else {
        // Atualiza a quantidade do item
        $sql_update = "UPDATE itens SET quantidade = quantidade - 1 WHERE id = ?";
        $stmt_update = $conexao->prepare($sql_update);
        $stmt_update->bind_param("i", $id_item);
        $stmt_update->execute();
        $stmt_update->close();

        // Registra a retirada na tabela 'retiradas'
        $sql_retirada = "INSERT INTO retiradas (item_id, nome, endereco, telefone, data_retirada) 
                         VALUES (?, ?, ?, ?, NOW())";
        $stmt_retirada = $conexao->prepare($sql_retirada);
        $stmt_retirada->bind_param("isss", $id_item, $nome, $endereco, $telefone);

        if ($stmt_retirada->execute()) {
            echo "Item retirado com sucesso!";
        } else {
            echo "Erro ao registrar a retirada: " . $conexao->error;
        }
        $stmt_retirada->close();
    }

    $conexao->close();

    // Redireciona de volta para a lista de itens
    header("Location: Tabelaitens.php");
    exit();
}
?>
<style>
    body {
        background: linear-gradient(to top left, #004A8D, #98c4ec);
    }
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retirar Item</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
</head>

<body>
    <section class="section">
        <div class="container">
            <h1 class="title">Retirar Item</h1>
            <h2 class="subtitle">Você está retirando o item: <?php echo htmlspecialchars($descricao); ?></h2>

            <form method="POST" action="retirar_item.php?id=<?php echo $id_item; ?>">
                <div class="field">
                    <label class="label">Nome do Retirante</label>
                    <div class="control">
                        <input class="input" type="text" name="nome" placeholder="Digite seu nome" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Endereço</label>
                    <div class="control">
                        <input class="input" type="text" name="endereco" placeholder="Digite seu endereço" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Telefone</label>
                    <div class="control">
                        <input class="input" type="text" name="telefone" placeholder="Digite seu telefone" required>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <button class="button is-danger" type="submit">Confirmar Retirada</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</body>

</html>
