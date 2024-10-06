<?php
session_start();
include('../../includes/database.php');
include('../../includes/auth.php');

// Verificar se o ID da fatura foi fornecido
if (isset($_GET['id'])) {
    $fatura_id = $_GET['id'];

    // Buscar os detalhes da fatura
    $sql = "SELECT * FROM contas_receber WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $fatura_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $fatura = $result->fetch_assoc();
} else {
    echo "ID da fatura não fornecido.";
    exit();
}

// Atualizar fatura quando o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $data_vencimento = $_POST['data_vencimento'];

    $sql = "UPDATE contas_receber SET descricao = ?, valor = ?, data_vencimento = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdsi", $descricao, $valor, $data_vencimento, $fatura_id);

    if ($stmt->execute()) {
        header("Location: listar_contas_receber.php");
        exit();
    } else {
        echo "Erro ao atualizar a fatura: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Fatura</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-3xl">
            <h2 class="text-2xl font-bold mb-6 text-center">Editar Fatura</h2>
            <form action="editar_fatura.php?id=<?php echo $fatura_id; ?>" method="POST" class="space-y-4">
                <div>
                    <label for="descricao" class="block text-gray-700">Descrição</label>
                    <input type="text" name="descricao" value="<?php echo $fatura['descricao']; ?>" required class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label for="valor" class="block text-gray-700">Valor</label>
                    <input type="number" name="valor" value="<?php echo $fatura['valor']; ?>" step="0.01" required class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label for="data_vencimento" class="block text-gray-700">Data de Vencimento</label>
                    <input type="date" name="data_vencimento" value="<?php echo $fatura['data_vencimento']; ?>" required class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
