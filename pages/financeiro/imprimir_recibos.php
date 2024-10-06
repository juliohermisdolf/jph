<?php
session_start();
include('../../includes/database.php');
include('../../includes/auth.php');

// Consultar todos os recibos avulsos
$sql = "SELECT ra.id, c.nome, ra.descricao, ra.valor, ra.data_emissao 
        FROM recibos_avulsos ra
        JOIN clientes c ON ra.cliente_id = c.id";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir Recibos</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .recibo { border: 1px solid #000; padding: 20px; width: 500px; margin: 20px auto; }
    </style>
</head>
<body>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($recibo = $result->fetch_assoc()): ?>
            <div class="recibo">
                <h1>Recibo</h1>
                <p><strong>Cliente:</strong> <?php echo $recibo['nome']; ?></p>
                <p><strong>Descrição:</strong> <?php echo $recibo['descricao']; ?></p>
                <p><strong>Valor:</strong> R$ <?php echo number_format($recibo['valor'], 2, ',', '.'); ?></p>
                <p><strong>Data de Emissão:</strong> <?php echo date('d/m/Y', strtotime($recibo['data_emissao'])); ?></p>
                <p>Assinatura: _____________________________________________</p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Nenhum recibo encontrado.</p>
    <?php endif; ?>

    <script>
        window.print();
    </script>
</body>
</html>
