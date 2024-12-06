<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Item</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.4/css/bulma.min.css">
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

        #imagePreview {
            width: 100%;
            max-height: 250px;
            object-fit: contain;
            border: 2px dashed #00c4a7;
            border-radius: 10px;
            display: none;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <section class="hero is-fullheight">
        <div class="hero-body">
            <div class="container">
                <h1 class="title has-text-centered">Cadastrar Item</h1>

                <?php
                session_start();
                if (isset($_SESSION['erro'])) {
                    echo "<div class='notification is-danger'>" . $_SESSION['erro'] . "</div>";
                    unset($_SESSION['erro']);
                }
                if (isset($_SESSION['sucesso'])) {
                    echo "<div class='notification is-success'>" . $_SESSION['sucesso'] . "</div>";
                    unset($_SESSION['sucesso']);
                }
                ?>

                <div class="box">
                    <form action="cadastrar_item.php" method="POST" enctype="multipart/form-data">
                        <div class="field">
                            <label class="label">Descrição</label>
                            <div class="control">
                                <input type="text" name="descricao" class="input" placeholder="Descrição do item" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Categoria</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select name="categoria" required>
                                        <option value="" disabled selected>Selecione uma categoria...</option>
                                        <?php
                                        include('conexao.php');
                                        $sql = "SELECT id, categoria FROM categoria";
                                        $result = $conexao->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['id'] . "'>" . $row['categoria'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Quantidade</label>
                            <div class="control">
                                <input type="number" name="quantidade" class="input" placeholder="Quantidade" min="0" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Imagem</label>
                            <div class="file has-name is-fullwidth">
                                <label class="file-label">
                                    <input class="file-input" type="file" name="imagem" accept="image/*" id="imageInput">
                                    <span class="file-cta">
                                        <span class="file-icon">
                                            <i class="fas fa-upload"></i>
                                        </span>
                                        <span class="file-label">Escolher imagem</span>
                                    </span>
                                    <span class="file-name" id="fileName">Nenhuma imagem selecionada</span>
                                </label>
                            </div>

                            <div class="field">
                                <img id="imagePreview" src="" alt="Pré-visualização da imagem" style="display:none;">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button is-fullwidth is-large">Cadastrar Item</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        const imageInput = document.getElementById('imageInput');
        const fileName = document.getElementById('fileName');
        const imagePreview = document.getElementById('imagePreview');

        imageInput.addEventListener('change', function (event) {
            const file = event.target.files[0];

            if (file) {
                fileName.textContent = file.name;
                const reader = new FileReader();

                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };

                reader.readAsDataURL(file);
            } else {
                fileName.textContent = 'Nenhuma imagem selecionada';
                imagePreview.style.display = 'none';
            }
        });
    </script>
</body>
</html>

<?php
session_start();
ob_start(); // Inicia o buffer de saída

include('conexao.php');

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recupera os dados do formulário
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
    $categoria = (int)$_POST['categoria'];
    $quantidade = (int)$_POST['quantidade'];
    
    // A lógica de disponibilidade deve ser numérica
    $disponibilidade = $quantidade > 0 ? 1 : 0; // 1 para Disponível, 0 para Indisponível
    
    $imagem = null;

    // Processa o upload da imagem
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        // Caminho absoluto para a pasta de uploads
        $pastaDestino = __DIR__ . '/uploads/';
        $nomeImagem = uniqid() . '-' . $_FILES['imagem']['name'];
        $caminhoImagem = $pastaDestino . basename($nomeImagem);

        // Verifica se a pasta de uploads existe, se não, tenta criar
        if (!is_dir($pastaDestino)) {
            mkdir($pastaDestino, 0777, true); // Cria a pasta se não existir
        }

        // Move o arquivo para o diretório de uploads
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem)) {
            $imagem = $caminhoImagem;
        } else {
            $_SESSION['erro'] = 'Erro ao fazer upload da imagem.';
            header('Location: cadastrar_item.php');
            exit();
        }
    }

    // Insere os dados no banco de dados
    $sql = "INSERT INTO itens (descricao, categoria, quantidade, disponibilidade, imagem) 
            VALUES ('$descricao', $categoria, $quantidade, $disponibilidade, '$imagem')";

    if (mysqli_query($conexao, $sql)) {
        $_SESSION['sucesso'] = 'Item cadastrado com sucesso!';
        header('Location: cadastrar_item.php');
        exit();
    } else {
        $_SESSION['erro'] = 'Erro ao cadastrar o item: ' . mysqli_error($conexao);
    }
}

mysqli_close($conexao);
ob_end_flush(); // Finaliza o buffer de saída
?>
