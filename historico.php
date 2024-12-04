<?php
include('conexao.php');
// Criar conexão com o banco de dados


// Verificar se a conexão foi bem-sucedida
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o ID do item foi informado via GET
if (isset($_GET['id_item'])) {
    $id_item = $_GET['id_item']; // Pega o valor do ID do item da URL

    // Consulta SQL para buscar os usuários que alugaram o item específico
    $sql = "
        SELECT u.usuario, u.email 
        FROM historico h
        JOIN usuario u ON h.id_Usuario = u.id
        WHERE h.id_Item = ?
    ";

    // Preparar e executar a consulta
    if ($stmt = $conexao->prepare($sql)) {
        // Vincular o parâmetro para a consulta preparada
        $stmt->bind_param("i", $id_item); // "i" para integer

        // Executar a consulta
        $stmt->execute();

        // Obter o resultado
        $result = $stmt->get_result();

        // Verificar se o resultado contém registros
        if ($result->num_rows > 0) {
            echo "<h3>Usuários que alugaram o item com ID $id_item:</h3>";

            // Exibir os resultados (usuários que alugaram o item)
            while ($row = $result->fetch_assoc()) {
                echo "Usuário: " . $row["usuario"] . "<br>";
                echo "E-mail: " . $row["email"] . "<br><br>";
            }
        } else {
            echo "Nenhum usuário alugou o item com ID $id_item.";
        }

        // Fechar a declaração
        $stmt->close();
    } else {
        // Se não conseguir preparar a consulta
        echo "Erro na consulta: " . $conn->error;
    }
} else {
    echo "Por favor, forneça o ID do item na URL (exemplo: ?id_item=1).";
}

// Fechar a conexão com o banco de dados
$conexao->close();
?>
