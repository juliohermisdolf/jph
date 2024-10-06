<?php
session_start();
include('../../includes/database.php');

// Verificar se o usuário está logado
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../../login.php');
    exit();
}

// Buscar todos os clientes no banco de dados
$sql = "SELECT * FROM clientes ORDER BY nome ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Sistema de Advocacia</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h2 class="text-2xl font-bold mb-6 text-center">Clientes</h2>
        
        <!-- Botão para adicionar novo cliente -->
        <div class="mb-4">
            <a href="adicionar_cliente.php" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">Adicionar Novo Cliente</a>
        </div>
        
        <!-- Tabela de Clientes -->
        <table class="min-w-full bg-white rounded-lg shadow-lg">
            <thead class="bg-blue-500 text-white">
                <tr>
                    <th class="py-2 px-4">ID</th>
                    <th class="py-2 px-4">Nome</th>
                    <th class="py-2 px-4">Email</th>
                    <th class="py-2 px-4">Telefone</th>
                    <th class="py-2 px-4">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class='border-b'>";
                        echo "<td class='py-2 px-4'>" . $row['id'] . "</td>";
                        echo "<td class='py-2 px-4'>" . $row['nome'] . "</td>";
                        echo "<td class='py-2 px-4'>" . $row['email'] . "</td>";
                        echo "<td class='py-2 px-4'>" . $row['telefone'] . "</td>";
                        echo "<td class='py-2 px-4'>";
                        echo "<a href='editar_cliente.php?id=" . $row['id'] . "' class='text-blue-500 hover:text-blue-700'>Editar</a> | ";
                        echo "<a href='remover_cliente.php?id=" . $row['id'] . "' class='text-red-500 hover:text-red-700'>Remover</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='py-4 text-center'>Nenhum cliente encontrado</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
