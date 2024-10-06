<?php
session_start();
include('../../includes/database.php');

$sql = "SELECT p.id, c.nome as cliente, p.tipo_processo, p.status, p.data_inicio FROM processos p INNER JOIN clientes c ON p.cliente_id = c.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Processos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h2 class="text-2xl font-bold mb-6 text-center">Lista de Processos</h2>
        <table class="min-w-full bg-white rounded-lg shadow-lg">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="py-2 px-4">ID do Processo</th>
                    <th class="py-2 px-4">Nome do Cliente</th>
                    <th class="py-2 px-4">Tipo de Processo</th>
                    <th class="py-2 px-4">Status</th>
                    <th class="py-2 px-4">Data de Início</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class='text-center border-b'>";
                        echo "<td class='py-2 px-4'>" . $row['id'] . "</td>";
                        echo "<td class='py-2 px-4'>" . $row['cliente'] . "</td>";
                        echo "<td class='py-2 px-4'>" . $row['tipo_processo'] . "</td>";
                        echo "<td class='py-2 px-4'>" . $row['status'] . "</td>";
                        echo "<td class='py-2 px-4'>" . $row['data_inicio'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='py-4'>Nenhum processo encontrado</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
