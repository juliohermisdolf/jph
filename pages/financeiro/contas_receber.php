<?php
session_start();
include('../../includes/database.php');
include('../../includes/auth.php');

// Consultar todas as contas a receber
$sql = "SELECT cr.id, c.nome, cr.descricao, cr.valor, cr.data_vencimento, cr.status 
        FROM contas_receber cr 
        JOIN clientes c ON cr.cliente_id = c.id 
        WHERE cr.status != 'inativo'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contas a Receber</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-5xl">
            <h2 class="text-2xl font-bold mb-6 text-center">Contas a Receber</h2>

            <!-- Tabela de Contas a Receber -->
            <table class="w-full table-auto bg-white border rounded-lg">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border">Cliente</th>
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
                                <td class="px-4 py-2 border"><?php echo $row['nome']; ?></td>
                                <td class="px-4 py-2 border"><?php echo $row['descricao']; ?></td>
                                <td class="px-4 py-2 border">R$ <?php echo number_format($row['valor'], 2, ',', '.'); ?></td>
                                <td class="px-4 py-2 border"><?php echo date('d/m/Y', strtotime($row['data_vencimento'])); ?></td>
                                <td class="px-4 py-2 border"><?php echo ucfirst($row['status']); ?></td>
                                <td class="px-4 py-2 border">
                                    <a href="editar_fatura.php?id=<?php echo $row['id']; ?>" class="bg-blue-500 text-white px-4 py-1 rounded-lg">Editar</a>
                                    <a href="excluir_fatura.php?id=<?php echo $row['id']; ?>" class="bg-red-500 text-white px-4 py-1 rounded-lg ml-2" onclick="return confirm('Tem certeza que deseja excluir esta fatura?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="px-4 py-2 text-center text-gray-500">Nenhuma conta a receber encontrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
