<?php
session_start();
include('../../includes/database.php');
include('../../includes/auth.php');

// Verificar se o ID do cliente foi fornecido
$cliente_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Consultar os créditos disponíveis
$sql = "SELECT SUM(valor) AS total_creditos FROM contas_receber WHERE cliente_id = ? AND status = 'recebido'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cliente_id);
$stmt->execute();
$result = $stmt->get_result();
$dados = $result->fetch_assoc();
$total_creditos = $dados['total_creditos'] ? $dados['total_creditos'] : 0;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Créditos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-3xl">
            <h2 class="text-2xl font-bold mb-6 text-center">Meus Créditos</h2>

            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                <p class="font-bold">Créditos Disponíveis</p>
                <p>R$ <?php echo number_format($total_creditos, 2, ',', '.'); ?></p>
            </div>
        </div>
    </div>
</body>
</html>
