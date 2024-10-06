<?php
session_start();
include('../../includes/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo = $_POST['tipo'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $data_vencimento = $_POST['data_vencimento'];

    $sql = "INSERT INTO financeiro (tipo, descricao, valor, data_vencimento) VALUES ('$tipo', '$descricao', '$valor', '$data_vencimento')";

    if ($conn->query($sql) === TRUE) {
        echo "<p class='text-green-500'>Conta cadastrada com sucesso!</p>";
    } else {
        echo "<p class='text-red-500'>Erro: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Contas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center">Cadastro de Contas</h2>
            <form action="contas.php" method="POST" class="space-y-4">
                <div>
                    <label for="tipo" class="block text-gray-700">Tipo de Conta</label>
                    <select name="tipo" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="pagar">Pagar</option>
                        <option value="receber">Receber</option>
                    </select>
                </div>
                <div>
                    <label for="descricao" class="block text-gray-700">Descrição</label>
                    <input type="text" name="descricao" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="valor" class="block text-gray-700">Valor</label>
                    <input type="number" step="0.01" name="valor" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="data_vencimento" class="block text-gray-700">Data de Vencimento</label>
                    <input type="date" name="data_vencimento" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">Cadastrar Conta</button>
            </form>
        </div>
    </div>
</body>
</html>
