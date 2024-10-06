<?php
session_start();
include('../../includes/database.php');
include('../../includes/auth.php');

// Consultar os cheques da empresa
$sql = "SELECT * FROM cheques_empresa";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cheques da Empresa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-5xl">
            <h2 class="text-2xl font-bold mb-6 text-center">Cheques da Empresa</h2>

            <!-- Tabela de Cheques -->
            <table class="w-full table-auto bg-white border rounded-lg">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border">ID Empresa</th>
                        <th class="px-4 py-2 border">Valor</th>
                        <th class="px-4 py-2 border">Data de Emissão</th>
                        <th class="px-4 py-2 border">Data de Vencimento</th>
                        <th class="px-4 py-2 border">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="px-4 py-2 border"><?php echo $row['empresa_id']; ?></td>
                                <td class="px-4 py-2 border">R$ <?php echo number_format($row['valor'], 2, ',', '.'); ?></td>
                                <td class="px-4 py-2 border"><?php echo date('d/m/Y', strtotime($row['data_emissao'])); ?></td>
                                <td class="px-4 py-2 border"><?php echo date('d/m/Y', strtotime($row['data_vencimento'])); ?></td>
                                <td class="px-4 py-2 border">
                                    <a href="excluir_cheque_empresa.php?id=<?php echo $row['id']; ?>" class="bg-red-500 text-white px-4 py-2 rounded-lg" onclick="return confirm('Tem certeza que deseja excluir este cheque?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-4 py-2 text-center text-gray-500">Nenhum cheque encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
