<?php
session_start();
include('../../includes/database.php');
include('../../includes/auth.php');

// Consultar receitas (contas recebidas)
$sql_receitas = "SELECT descricao, valor, data_pagamento FROM contas_receber WHERE status = 'recebido'";
$result_receitas = $conn->query($sql_receitas);

// Consultar despesas
$sql_despesas = "SELECT descricao, valor, data_lancamento FROM despesas";
$result_despesas = $conn->query($sql_despesas);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fluxo de Caixa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-5xl">
            <h2 class="text-2xl font-bold mb-6 text-center">Fluxo de Caixa</h2>

            <div class="mb-6">
                <h3 class="text-lg font-bold mb-2">Receitas</h3>
                <table class="w-full table-auto bg-white border rounded-lg">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">Descrição</th>
                            <th class="px-4 py-2 border">Valor</th>
                            <th class="px-4 py-2 border">Data de Pagamento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result_receitas->num_rows > 0): ?>
                            <?php while ($row = $result_receitas->fetch_assoc()): ?>
                                <tr>
                                    <td class="px-4 py-2 border"><?php echo $row['descricao']; ?></td>
                                    <td class="px-4 py-2 border">R$ <?php echo number_format($row['valor'], 2, ',', '.'); ?></td>
                                    <td class="px-4 py-2 border"><?php echo date('d/m/Y', strtotime($row['data_pagamento'])); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="px-4 py-2 text-center text-gray-500">Nenhuma receita encontrada.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-2">Despesas</h3>
                <table class="w-full table-auto bg-white border rounded-lg">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">Descrição</th>
                            <th class="px-4 py-2 border">Valor</th>
                            <th class="px-4 py-2 border">Data de Lançamento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result_despesas->num_rows > 0): ?>
                            <?php while ($row = $result_despesas->fetch_assoc()): ?>
                                <tr>
                                    <td class="px-4 py-2 border"><?php echo $row['descricao']; ?></td>
                                    <td class="px-4 py-2 border">R$ <?php echo number_format($row['valor'], 2, ',', '.'); ?></td>
                                    <td class="px-4 py-2 border"><?php echo date('d/m/Y', strtotime($row['data_lancamento'])); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="px-4 py-2 text-center text-gray-500">Nenhuma despesa encontrada.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
