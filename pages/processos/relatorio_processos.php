<?php
session_start();
include('../../includes/database.php');

// Total de processos ativos
$sql_ativos = "SELECT COUNT(*) AS total_ativos FROM processos WHERE status = 'ativo'";
$result_ativos = $conn->query($sql_ativos);
$total_ativos = $result_ativos->fetch_assoc()['total_ativos'];

// Total de processos finalizados
$sql_finalizados = "SELECT COUNT(*) AS total_finalizados FROM processos WHERE status = 'finalizado'";
$result_finalizados = $conn->query($sql_finalizados);
$total_finalizados = $result_finalizados->fetch_assoc()['total_finalizados'];

// Total de processos em andamento
$sql_andamento = "SELECT COUNT(*) AS total_andamento FROM processos WHERE status = 'em andamento'";
$result_andamento = $conn->query($sql_andamento);
$total_andamento = $result_andamento->fetch_assoc()['total_andamento'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Processos</title>
</head>
<body>
    <h2>Relatório de Processos</h2>
    <table border="1">
        <tr>
            <th>Processos Ativos</th>
            <th>Processos Finalizados</th>
            <th>Processos em Andamento</th>
        </tr>
        <tr>
            <td><?php echo $total_ativos; ?></td>
            <td><?php echo $total_finalizados; ?></td>
            <td><?php echo $total_andamento; ?></td>
        </tr>
    </table>
</body>
</html>
