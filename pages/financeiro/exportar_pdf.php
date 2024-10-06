<?php
session_start();
include('../../includes/database.php');
include('../../includes/auth.php');
require('../../includes/fpdf/fpdf.php');

// Definir as datas do filtro (padrão: último mês)
$data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : date('Y-m-01');
$data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : date('Y-m-t');

// Consultar receitas
$sql_receitas = "SELECT descricao, valor, data_pagamento FROM contas_receber 
                 WHERE data_pagamento BETWEEN ? AND ? AND status = 'recebido'";
$stmt = $conn->prepare($sql_receitas);
$stmt->bind_param("ss", $data_inicio, $data_fim);
$stmt->execute();
$result_receitas = $stmt->get_result();

// Consultar despesas
$sql_despesas = "SELECT descricao, valor, data_lancamento FROM despesas 
                 WHERE data_lancamento BETWEEN ? AND ?";
$stmt = $conn->prepare($sql_despesas);
$stmt->bind_param("ss", $data_inicio, $data_fim);
$stmt->execute();
$result_despesas = $stmt->get_result();

// Criar PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'Relatorio Financeiro', 0, 1, 'C');

// Títulos das tabelas
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(95, 10, 'Receitas', 1, 0, 'C');
$pdf->Cell(95, 10, 'Despesas', 1, 1, 'C');

// Receitas
$pdf->SetFont('Arial', '', 12);
if ($result_receitas->num_rows > 0) {
    while ($row = $result_receitas->fetch_assoc()) {
        $pdf->Cell(95, 10, $row['descricao'], 1, 0);
        $pdf->Cell(95, 10, 'R$ ' . number_format($row['valor'], 2, ',', '.'), 1, 1);
    }
} else {
    $pdf->Cell(190, 10, 'Nenhuma receita encontrada.', 1, 1, 'C');
}

// Despesas
if ($result_despesas->num_rows > 0) {
    while ($row = $result_despesas->fetch_assoc()) {
        $pdf->Cell(95, 10, $row['descricao'], 1, 0);
        $pdf->Cell(95, 10, 'R$ ' . number_format($row['valor'], 2, ',', '.'), 1, 1);
    }
} else {
    $pdf->Cell(190, 10, 'Nenhuma despesa encontrada.', 1, 1, 'C');
}

// Gerar PDF
$pdf->Output('I', 'Relatorio_Financeiro.pdf');
?>
