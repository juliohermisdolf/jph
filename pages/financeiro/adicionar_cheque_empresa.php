<?php
session_start();
include('../../includes/database.php');
include('../../includes/auth.php');

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $empresa_id = $_POST['empresa_id'];
    $valor = $_POST['valor'];
    $data_emissao = $_POST['data_emissao'];
    $data_vencimento = $_POST['data_vencimento'];

    // Inserir cheque da empresa no banco de dados
    $sql = "INSERT INTO cheques_empresa (empresa_id, valor, data_emissao, data_vencimento) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idss", $empresa_id, $valor, $data_emissao, $data_vencimento);

    if ($stmt->execute()) {
        header("Location: listar_cheques_empresa.php");
        exit();
    } else {
        echo "Erro ao lançar cheque da empresa: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Cheque da Empresa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-3xl">
            <h2 class="text-2xl font-bold mb-6 text-center">Adicionar Cheque da Empresa</h2>
            <form action="adicionar_cheque_empresa.php" method="POST" class="space-y-4">
                <div>
                    <label for="empresa_id" class="block text-gray-700">ID da Empresa</label>
                    <input type="number" name="empresa_id" required class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label for="valor" class="block text-gray-700">Valor</label>
                    <input type="number" name="valor" step="0.01" required class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label for="data_emissao" class="block text-gray-700">Data de Emissão</label>
                    <input type="date" name="data_emissao" required class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label for="data_vencimento" class="block text-gray-700">Data de Vencimento</label>
                    <input type="date" name="data_vencimento" required class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-lg">Lançar Cheque</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
