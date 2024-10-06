<?php
session_start();
include('../../includes/database.php');

// Consultar o total de contas pagas e recebidas
$sql_pagar = "SELECT SUM(valor) AS total_pagar FROM financeiro WHERE tipo = 'pagar' AND status = 'pago'";
$result_pagar = $conn->query($sql_pagar);
$total_pagar = $result_pagar->fetch_assoc()['total_pagar'];

$sql_receber = "SELECT SUM(valor) AS total_receber FROM financeiro WHERE tipo = 'receber' AND status = 'pago'";
$result_receber = $conn->query($sql_receber);
$total_receber = $result_receber->fetch_assoc()['total_receber'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfico de Fluxo de Caixa</title>
    <script src="https://cdn.tailwindcss.com"></script>  <!-- Tailwind CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>  <!-- Chart.js CDN -->
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h2 class="text-2xl font-bold mb-6 text-center">Gráfico de Fluxo de Caixa</h2>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <canvas id="fluxoCaixaChart" width="400" height="200"></canvas>
        </div>
    </div>

    <script>
        var ctx = document.getElementById('fluxoCaixaChart').getContext('2d');
        var fluxoCaixaChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Contas Pagas', 'Contas Recebidas'],
                datasets: [{
                    label: 'Valor em R$',
                    data: [<?php echo $total_pagar ? $total_pagar : 0; ?>, <?php echo $total_receber ? $total_receber : 0; ?>],
                    backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(75, 192, 192, 0.2)'],
                    borderColor: ['rgba(255, 99, 132, 1)', 'rgba(75, 192, 192, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
