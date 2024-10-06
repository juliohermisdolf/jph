<?php
session_start();
include('../../includes/database.php');
include('../../includes/auth.php');

// Definir as datas do filtro (padrão: último mês)
$data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : date('Y-m-01');
$data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : date('Y-m-t');

// Consultar receitas
$sql_receitas = "SELECT descricao, valor, data_pagamento FROM contas_receber 
                 WHERE data_pagamento BETWEEN ? AND ? AND status = 'recebido'";
$stmt = $conn->prepare($sql_receitas);
if (!$stmt) {
    die("Erro na preparação da consulta de receitas: " . $conn->error);
}
$stmt->bind_param("ss", $data_inicio, $data_fim);
$stmt->execute();
$result_receitas = $stmt->get_result();
if (!$result_receitas) {
    die("Erro ao executar consulta de receitas: " . $stmt->error);
}

// Consultar despesas
$sql_despesas = "SELECT descricao, valor, data_lancamento FROM despesas 
                 WHERE data_lancamento BETWEEN ? AND ?";
$stmt = $conn->prepare($sql_despesas);
if (!$stmt) {
    die("Erro na preparação da consulta de despesas: " . $conn->error);
}
$stmt->bind_param("ss", $data_inicio, $data_fim);
$stmt->execute();
$result_despesas = $stmt->get_result();
if (!$result_despesas) {
    die("Erro ao executar consulta de despesas: " . $stmt->error);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Financeiro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-5xl">
            <h2 class="text-2xl font-bold mb-6 text-center">Relatório Financeiro</h2>

            <!-- Formulário de Filtro -->
            <form action="relatorio_financeiro.php" method="GET" class="grid grid-cols-2 gap-4 mb-6">
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
            <div class="mb-6 text-right">
    <a href="exportar_pdf.php?data_inicio=<?php echo $data_inicio; ?>&data_fim=<?php echo $data_fim; ?>" class="bg-red-500 text-white px-4 py-2 rounded-lg">Exportar PDF</a>
    <a href="exportar_excel.php?data_inicio=<?php echo $data_inicio; ?>&data_fim=<?php echo $data_fim; ?>" class="bg-green-500 text-white px-4 py-2 rounded-lg ml-2">Exportar Excel</a>
</div>


            <!-- Resultados -->
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
