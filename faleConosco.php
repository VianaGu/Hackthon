<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fale Conosco</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
    <style>
        body {
            background: linear-gradient(to top left, #004A8D, #98c4ec);
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 50px;
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .message {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <section class="section">
        <div class="container">
            <h1 class="title">Fale Conosco</h1>
            <p class="subtitle">Envie-nos uma mensagem! Retornaremos o mais rápido possível.</p>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Informações do e-mail
                $para = "liviamtoali@gmail.com";
                $assunto = "Contato via site";

                // Captura os dados do formulário
                $nome = htmlspecialchars(trim($_POST['nome']));
                $email = htmlspecialchars(trim($_POST['email']));
                $mensagem = htmlspecialchars(trim($_POST['mensagem']));

                // Monta o conteúdo do e-mail
                $conteudo = "Nome: $nome\n";
                $conteudo .= "E-mail: $email\n\n";
                $conteudo .= "Mensagem:\n$mensagem\n";

                // Cabeçalhos para o envio do e-mail
                $headers = "From: $email\r\n";
                $headers .= "Reply-To: $email\r\n";
                $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

                // Tenta enviar o e-mail
                if (mail($para, $assunto, $conteudo, $headers)) {
                    echo '<div class="notification is-success">Mensagem enviada com sucesso!</div>';
                } else {
                    echo '<div class="notification is-danger">Ocorreu um erro ao enviar sua mensagem. Tente novamente mais tarde.</div>';
                }
            }
            ?>

            <form method="POST" action="">
                <div class="field">
                    <label class="label">Nome</label>
                    <div class="control">
                        <input class="input" type="text" name="nome" placeholder="Seu nome" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">E-mail</label>
                    <div class="control">
                        <input class="input" type="email" name="email" placeholder="Seu e-mail" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Mensagem</label>
                    <div class="control">
                        <textarea class="textarea" name="mensagem" placeholder="Escreva sua mensagem" required></textarea>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <button class="button is-link" type="submit">Enviar</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</body>

</html>
