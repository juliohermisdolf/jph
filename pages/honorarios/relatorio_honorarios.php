<?php
session_start();
include('../../includes/database.php');

$sql = "SELECT h.id, p.tipo_processo, h.valor, h.status, h.data_pagamento 
        FROM honorarios h 
        INNER JOIN processos p ON h.processo_id = p.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Honorários</title>
</head>
<body>
    <h2>Relatório de Honorários</h2>
    <table border="1">
        <tr>
            <th>ID do Honorário</th>
            <th>Tipo de Processo</th>
            <th>Valor</th>
            <th>Status</th>
            <th>Data de Pagamento</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['tipo_processo'] . "</td>";
                echo "<td>R$ " . $row['valor'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td>" . $row['data_pagamento'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Nenhum honorário encontrado</td></tr>";
        }
        ?>
    </table>
</body>
</html>
