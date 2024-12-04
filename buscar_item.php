<?php
include('conexao.php');

if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    // Consulta SQL para buscar o produto pelo código
    $sql = "
        SELECT 
            itens.id, 
            itens.descricao, 
            categoria.categoria AS nome_categoria, 
            itens.quantidade, 
            itens.disponibilidade
        FROM itens
        INNER JOIN categoria ON itens.categoria = categoria.id
        WHERE itens.id = ?"; // Usar o ID para procurar o produto
    
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('i', $codigo); // 'i' é para inteiro
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $produto = $result->fetch_assoc();
        // Retorna os dados como JSON
        echo json_encode($produto);
    } else {
        // Caso não encontre o produto
        echo json_encode(['erro' => 'Produto não encontrado']);
    }

    $stmt->close();
    $conexao->close();
}
?>
