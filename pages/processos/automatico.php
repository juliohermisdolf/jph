<?php
session_start();
include('../../includes/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $tipo_processo = $_POST['tipo_processo'];
    $status = $_POST['status'];

    $sql = "INSERT INTO processos (cliente_id, tipo_processo, status) VALUES ('$cliente_id', '$tipo_processo', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "<p class='text-green-500'>Processo cadastrado com sucesso!</p>";
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
    <title>Cadastrar Processo Automático</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center">Cadastrar Processo Automático</h2>
            <form action="automatico.php" method="POST" class="space-y-4">
                <div>
                    <label for="cliente_id" class="block text-gray-700">ID do Cliente</label>
                    <input type="text" name="cliente_id" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="tipo_processo" class="block text-gray-700">Tipo de Processo</label>
                    <input type="text" name="tipo_processo" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="status" class="block text-gray-700">Status</label>
                    <input type="text" name="status" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">Cadastrar Processo</button>
            </form>
        </div>
    </div>
</body>
</html>
