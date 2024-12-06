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
            background: linear-gradient(135deg, #0072ff, #00c4a7); /* Gradiente suave laranja/rosado */
            color: #fff;
            font-weight: bold;
            border: none;
            border-radius: 8px; /* Arredondamento suave */
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); /* Sombra para efeito 3D */
        }

        .button.is-fullwidth:hover {
            transform: scale(1.05); /* Leve aumento no hover */
            box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.3); /* Sombra mais profunda */
            background: linear-gradient(135deg, #00c4a7, #0072ff); /* Gradiente invertido no hover */
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
                <div class="columns is-centered">
                    <!-- Coluna para o formulário principal -->
                    <div class="column is-5">
                        <h1 class="title has-text-centered">Cadastro de Produto</h1>
                        <!-- Removido qualquer mensagem de erro relacionada ao banco -->
                        <div class="box">
                            <form action="cadastroproduto.php" method="POST" enctype="multipart/form-data">
                                <div class="field">
                                    <label class="label">Descrição do Produto</label>
                                    <div class="control">
                                        <input type="text" name="descricao" class="input" placeholder="Ex: Notebook Gamer" required>
                                    </div>
                                </div>

                                <div class="field">
    <label class="label">Categoria</label>
    <div class="control">
        <div class="select is-fullwidth">
            <select name="categoria" required>
                <option value="" disabled selected>Selecione uma categoria...</option>
                <?php while ($categoria = mysqli_fetch_assoc($resultCategorias)): ?>
                    <option value="<?= $categoria['id']; ?>"><?= $categoria['nome']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
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
                            </div>
                        </div>

                        <!-- Coluna para anexar a imagem -->
                        <div class="column is-5">
                            <div class="box">
                                <h2 class="subtitle has-text-centered">Anexar Imagem</h2>
                                <div class="field">
                                    <label class="label">Imagem do Produto</label>
                                    <div class="file has-name is-fullwidth">
                                        <label class="file-label">
                                            <input class="file-input" type="file" name="imagem" accept="image/*" id="imageInput" >
                                            <span class="file-cta">
                                                <span class="file-icon">
                                                    <i class="fas fa-upload"></i>
                                                </span>
                                                <span class="file-label">Escolher arquivo</span>
                                            </span>
                                            <span class="file-name" id="fileName">Nenhum arquivo selecionado</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="field">
                                    <img id="imagePreview" alt="Pré-visualização da Imagem">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="columns is-centered">
                        <div class="column is-10">
                            <div class="field">
                                <button type="submit" class="button is-fullwidth is-large">Cadastrar Produto</button>
                            </div>
                            <div class="has-text-centered">
    <a href="Hackthon/HomePage/index.html" class="button is-small is-light">Voltar ao Menu</a>
</div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        // Atualiza o nome do arquivo e exibe a pré-visualização
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
                fileName.textContent = 'Nenhum arquivo selecionado';
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

// Busca as categorias no banco de dados
$sqlCategorias = "SELECT id, nome FROM categorias";
$resultCategorias = mysqli_query($conexao, $sqlCategorias);

if (!$resultCategorias) {
    die("Erro ao buscar categorias: " . mysqli_error($conexao));
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recupera os dados do formulário
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
    $categoria = (int)$_POST['categoria'];
    $quantidade = (int)$_POST['quantidade'];
    
    // A lógica de disponibilidade deve ser numérica
    $disponibilidade = $quantidade > 0 ? 1 : 0; // 1 para Disponível, 0 para Indisponível
    
    $imagem = null;

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
    // Pega o nome original do arquivo
    $nomeImagem = basename($_FILES['imagem']['name']); 

    // Caminho absoluto para a pasta de uploads
    $pastaDestino = __DIR__ . '/uploads/';
    $caminhoImagem = $pastaDestino . $nomeImagem;

    // Verifica se a pasta de uploads existe, se não, tenta criar
    if (!is_dir($pastaDestino)) {
        mkdir($pastaDestino, 0777, true); // Cria a pasta se não existir
    }

    // Move o arquivo para o diretório de uploads
    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem)) {
        $imagem = $nomeImagem; // Apenas o nome do arquivo será salvo no banco
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