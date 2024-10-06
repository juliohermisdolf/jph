<?php
session_start();
include('../../includes/database.php');
include('../../includes/auth.php');

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $data_lancamento = $_POST['data_lancamento'];

    // Inserir despesa no banco de dados
    $sql = "INSERT INTO despesas (descricao, valor, data_lancamento) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sds", $descricao, $valor, $data_lancamento);

    if ($stmt->execute()) {
        header("Location: listar_despesas.php");
        exit();
    } else {
        echo "Erro ao lançar despesa: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lançamento de Despesa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-3xl">
            <h2 class="text-2xl font-bold mb-6 text-center">Lançar Despesa</h2>
            <form action="adicionar_despesa.php" method="POST" class="space-y-4">
                <div>
                    <label for="descricao" class="block text-gray-700">Descrição</label>
                    <input type="text" name="descricao" required class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label for="valor" class="block text-gray-700">Valor</label>
                    <input type="number" name="valor" step="0.01" required class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label for="data_lancamento" class="block text-gray-700">Data de Lançamento</label>
                    <input type="date" name="data_lancamento" required class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-lg">Lançar Despesa</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
