<?php
session_start();
include('../../includes/database.php');
include('../../includes/auth.php');

// Verificar se o ID do recibo foi fornecido
if (isset($_GET['id'])) {
    $recibo_id = $_GET['id'];

    // Consultar detalhes do recibo
    $sql = "SELECT ra.id, c.nome, ra.descricao, ra.valor, ra.data_emissao 
            FROM recibos_avulsos ra 
            JOIN clientes c ON ra.cliente_id = c.id 
            WHERE ra.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $recibo_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $recibo = $result->fetch_assoc();
    } else {
        echo "Recibo não encontrado.";
        exit();
    }
} else {
    echo "ID do recibo não fornecido.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir Recibo</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .recibo { border: 1px solid #000; padding: 20px; width: 500px; margin: 0 auto; }
    </style>
</head>
<body>
    <div class="recibo">
        <h1>Recibo</h1>
        <p><strong>Cliente:</strong> <?php echo $recibo['nome']; ?></p>
        <p><strong>Descrição:</strong> <?php echo $recibo['descricao']; ?></p>
        <p><strong>Valor:</strong> R$ <?php echo number_format($recibo['valor'], 2, ',', '.'); ?></p>
        <p><strong>Data de Emissão:</strong> <?php echo date('d/m/Y', strtotime($recibo['data_emissao'])); ?></p>
        <p>Assinatura: _____________________________________________</p>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
