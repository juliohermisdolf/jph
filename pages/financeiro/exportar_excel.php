<?php
session_start();
include('../../includes/database.php');
include('../../includes/auth.php');

// Definir as datas do filtro (padrão: último mês)
$data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : date('Y-m-01');
$data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : date('Y-m-t');

// Definir cabeçalhos para o arquivo Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Relatorio_Financeiro.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Consultar receitas
$sql_receitas = "SELECT descricao, valor, data_pagamento FROM contas_receber 
                 WHERE data_pagamento BETWEEN '$data_inicio' AND '$data_fim' AND status = 'recebido'";
$result_receitas = $conn->query($sql_receitas);

// Consultar despesas
$sql_despesas = "SELECT descricao, valor, data_lancamento FROM despesas 
                 WHERE data_lancamento BETWEEN '$data_inicio' AND '$data_fim'";
$result_despesas = $conn->query($sql_despesas);

// Criar a tabela do Excel
echo "<table border='1'>";
echo "<tr><th>Receitas</th><th>Despesas</th></tr>";

// Exibir receitas
if ($result_receitas->num_rows > 0) {
    while ($row = $result_receitas->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['descricao'] . " - R$ " . number_format($row['valor'], 2, ',', '.') . "</td>";
        echo "<td></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='2'>Nenhuma receita encontrada.</td></tr>";
}

// Exibir despesas
if ($result_despesas->num_rows > 0) {
    while ($row = $result_despesas->fetch_assoc()) {
        echo "<tr>";
        echo "<td></td>";
        echo "<td>" . $row['descricao'] . " - R$ " . number_format($row['valor'], 2, ',', '.') . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='2'>Nenhuma despesa encontrada.</td></tr>";
}

echo "</table>";
?>
