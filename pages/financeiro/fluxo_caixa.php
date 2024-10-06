<?php
session_start();
include('../../includes/database.php');
include('../../includes/auth.php');

// Definir datas de filtro (padrão: último mês)
$data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : date('Y-m-01');
$data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : date('Y-m-t');

// Consultar entradas (Contas a Receber)
$sql_receitas = "SELECT SUM(valor) AS total_receitas FROM contas_receber 
                 WHERE data_pagamento BETWEEN ? AND ? AND status = 'recebido'";
$stmt = $conn->prepare($sql_receitas);
$stmt->bind_param("ss", $data_inicio, $data_fim);
$stmt->execute();
$stmt->bind_result($total_receitas);
$stmt->fetch();
$stmt->close();

// Consultar saídas (Contas a Pagar e Despesas)
$sql_despesas = "SELECT 
                    (SELECT SUM(valor) FROM contas_pagar WHERE data_pagamento BETWEEN ? AND ? AND status = 'pago') +
                    (SELECT SUM(valor) FROM despesas WHERE data_lancamento BETWEEN ? AND ?) AS total_despesas";
$stmt = $conn->prepare($sql_despesas);
$stmt->bind_param("ssss", $data_inicio, $data_fim, $data_inicio, $data_fim);
$stmt->execute();
$stmt->bind_result($total_despesas);
$stmt->fetch();
$stmt->close();

// Calcular saldo
$saldo = $total_receitas - $total_despesas;

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
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-4xl">
            <h2 class="text-2xl font-bold mb-6 text-center">Fluxo de Caixa</h2>

            <!-- Formulário de Filtro -->
            <form action="fluxo_caixa.php" method="GET" class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="data_inicio" class="block text-gray-700">Data Início</label>
                    <input type="date" name="data_inicio" value="<?php echo $data_inicio; ?>" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label for="data_fim" class="block text-gray-700">Data Fim</label>
                    <input type="date" name="data_fim" value="<?php echo $data_fim; ?>" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div class="col-span-2">
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">Filtrar</button>
                </div>
            </form>

            <!-- Resultados do Fluxo de Caixa -->
            <div class="grid grid-cols-3 gap-6">
                <div class="p-4 bg-green-100 text-green-700 rounded-lg shadow">
                    <h3 class="text-lg font-bold">Total Receitas</h3>
                    <p class="text-2xl">R$ <?php echo number_format($total_receitas, 2, ',', '.'); ?></p>
                </div>
                <div class="p-4 bg-red-100 text-red-700 rounded-lg shadow">
                    <h3 class="text-lg font-bold">Total Despesas</h3>
                    <p class="text-2xl">R$ <?php echo number_format($total_despesas, 2, ',', '.'); ?></p>
                </div>
                <div class="p-4 bg-blue-100 text-blue-700 rounded-lg shadow">
                    <h3 class="text-lg font-bold">Saldo</h3>
                    <p class="text-2xl">R$ <?php echo number_format($saldo, 2, ',', '.'); ?></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
