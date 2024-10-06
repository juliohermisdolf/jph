<?php
session_start();
include('../../includes/database.php');
include('../../includes/auth.php');

// Consultar todas as contas a pagar
$sql = "SELECT cp.id, f.nome AS fornecedor, cp.descricao, cp.valor, cp.data_vencimento, cp.status 
        FROM contas_pagar cp 
        JOIN fornecedores f ON cp.fornecedor_id = f.id 
        WHERE cp.status != 'inativo'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contas a Pagar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-5xl">
            <h2 class="text-2xl font-bold mb-6 text-center">Contas a Pagar</h2>

            <!-- Tabela de Contas a Pagar -->
            <table class="w-full table-auto bg-white border rounded-lg">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border">Fornecedor</th>
                        <th class="px-4 py-2 border">Descrição</th>
                        <th class="px-4 py-2 border">Valor</th>
                        <th class="px-4 py-2 border">Vencimento</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="px-4 py-2 border"><?php echo $row['fornecedor']; ?></td>
                                <td class="px-4 py-2 border"><?php echo $row['descricao']; ?></td>
                                <td class="px-4 py-2 border">R$ <?php echo number_format($row['valor'], 2, ',', '.'); ?></td>
                                <td class="px-4 py-2 border"><?php echo date('d/m/Y', strtotime($row['data_vencimento'])); ?></td>
                                <td class="px-4 py-2 border"><?php echo ucfirst($row['status']); ?></td>
                                <td class="px-4 py-2 border">
                                    <a href="editar_conta_pagar.php?id=<?php echo $row['id']; ?>" class="bg-blue-500 text-white px-4 py-1 rounded-lg">Editar</a>
                                    <a href="excluir_conta_pagar.php?id=<?php echo $row['id']; ?>" class="bg-red-500 text-white px-4 py-1 rounded-lg ml-2" onclick="return confirm('Tem certeza que deseja excluir esta conta?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="px-4 py-2 text-center text-gray-500">Nenhuma conta a pagar encontrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
