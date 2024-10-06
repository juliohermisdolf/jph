<?php
session_start();
include('../../includes/database.php');
include('../../includes/auth.php');

// Consultar totais de receitas (Contas a Receber) e despesas (Contas a Pagar + Despesas)
$sql_receitas = "SELECT SUM(valor) AS total_receitas FROM contas_receber WHERE status = 'recebido'";
$sql_despesas_pagar = "SELECT SUM(valor) AS total_despesas_pagar FROM contas_pagar WHERE status = 'pago'";
$sql_despesas = "SELECT SUM(valor) AS total_despesas FROM despesas";

$result_receitas = $conn->query($sql_receitas);
$result_despesas_pagar = $conn->query($sql_despesas_pagar);
$result_despesas = $conn->query($sql_despesas);

$total_receitas = $result_receitas->fetch_assoc()['total_receitas'] ?? 0;
$total_despesas_pagar = $result_despesas_pagar->fetch_assoc()['total_despesas_pagar'] ?? 0;
$total_despesas = $result_despesas->fetch_assoc()['total_despesas'] ?? 0;

// Calcular saldo
$saldo_total = $total_receitas - ($total_despesas_pagar + $total_despesas);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumo Financeiro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-5xl">
            <h2 class="text-2xl font-bold mb-6 text-center">Resumo Financeiro</h2>

            <div class="grid grid-cols-3 gap-6">
                <div class="p-4 bg-green-100 text-green-700 rounded-lg shadow">
                    <h3 class="text-lg font-bold">Total Receitas</h3>
                    <p class="text-2xl">R$ <?php echo number_format($total_receitas, 2, ',', '.'); ?></p>
                </div>
                <div class="p-4 bg-red-100 text-red-700 rounded-lg shadow">
                    <h3 class="text-lg font-bold">Total Despesas</h3>
                    <p class="text-2xl">R$ <?php echo number_format($total_despesas + $total_despesas_pagar, 2, ',', '.'); ?></p>
                </div>
                <div class="p-4 bg-blue-100 text-blue-700 rounded-lg shadow">
                    <h3 class="text-lg font-bold">Saldo Total</h3>
                    <p class="text-2xl">R$ <?php echo number_format($saldo_total, 2, ',', '.'); ?></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
