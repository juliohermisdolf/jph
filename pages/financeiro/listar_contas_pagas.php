<?php
session_start();
include('../../includes/database.php');
include('../../includes/auth.php');

// Consultar as contas pagas
$sql = "SELECT * FROM contas_pagar WHERE status = 'pago'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contas Pagas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-5xl">
            <h2 class="text-2xl font-bold mb-6 text-center">Contas Pagas</h2>

            <!-- Tabela de Contas Pagas -->
            <table class="w-full table-auto bg-white border rounded-lg">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border">Descrição</th>
                        <th class="px-4 py-2 border">Valor</th>
                        <th class="px-4 py-2 border">Data de Vencimento</th>
                        <th class="px-4 py-2 border">Data de Pagamento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="px-4 py-2 border"><?php echo $row['descricao']; ?></td>
                                <td class="px-4 py-2 border">R$ <?php echo number_format($row['valor'], 2, ',', '.'); ?></td>
                                <td class="px-4 py-2 border"><?php echo date('d/m/Y', strtotime($row['data_vencimento'])); ?></td>
                                <td class="px-4 py-2 border"><?php echo date('d/m/Y', strtotime($row['data_pagamento'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-center text-gray-500">Nenhuma conta paga encontrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
