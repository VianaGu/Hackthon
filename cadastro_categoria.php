<?php
include('conexao.php'); // Inclui a conexão com o banco de dados
include('verificaLogin.php'); // Verifica se o usuário está logado

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe o nome da categoria do formulário
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';

    // Verifica se o nome da categoria não está vazio
    if (!empty($categoria)) {
        // Prepara a query para inserir a categoria no banco de dados
        $sql = "INSERT INTO categoria (categoria) VALUES (?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $categoria); // 's' indica que o parâmetro é uma string
        if ($stmt->execute()) {
            $mensagem = "Categoria cadastrada com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar categoria.";
        }
        $stmt->close();
    } else {
        $mensagem = "O nome da categoria não pode estar vazio.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Cadastro de Categoria</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
    <style>
        body {
            background: linear-gradient(to top left, #004A8D, #98c4ec);
            height: 37rem;
        }
    </style>
</head>

<body>
    <section class="section">
        <div class="container">
            <h1 class="title has-text-white">Cadastro de Categoria</h1>

            <!-- Mensagem de feedback -->
            <?php if (isset($mensagem)) { ?>
                <div class="notification is-info">
                    <?php echo htmlspecialchars($mensagem); ?>
                </div>
            <?php } ?>

            <!-- Formulário para cadastrar categoria -->
            <form method="POST">
                <div class="field">
                    <label class="label has-text-white">Nome da Categoria:</label>
                    <div class="control">
                        <input class="input" type="text" name="categoria" placeholder="Digite o nome da categoria" required>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-primary">Cadastrar Categoria</button>
                    </div>
                </div>
            </form>

            <!-- Botões para navegação -->
            <div class="button-container">
                <a href="lista_categorias.php" class="button is-link">Ver Categorias</a>
                <a href="HomePage/index.html" class="button is-info">Home</a>
            </div>
        </div>
    </section>
</body>

</html>
