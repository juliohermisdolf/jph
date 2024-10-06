<?php
session_start();
include('../../includes/database.php');
include('../../includes/auth.php');

// Adicionar Conta a Pagar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fornecedor_id = $_POST['fornecedor_id'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $data_vencimento = $_POST['data_vencimento'];

    // Inserir conta a pagar no banco de dados
    $sql = "INSERT INTO contas_pagar (fornecedor_id, descricao, valor, data_vencimento) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isds", $fornecedor_id, $descricao, $valor, $data_vencimento);
    if ($stmt->execute()) {
        header("Location: contas_pagar.php");
        exit();
    } else {
        echo "Erro ao adicionar conta a pagar: " . $conn->error;
    }
}

// Consultar os fornecedores para o formulário
$sql_fornecedores = "SELECT id, nome FROM fornecedores";
$result_fornecedores = $conn->query($sql_fornecedores);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Conta a Pagar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center">Adicionar Conta a Pagar</h2>

            <form action="adicionar_conta_pagar.php" method="POST">
                <div class="mb-4">
                    <label for="fornecedor_id" class="block text-gray-700">Fornecedor</label>
                    <select name="fornecedor_id" class="w-full px-4 py-2 border rounded-lg" required>
                        <?php while ($fornecedor = $result_fornecedores->fetch_assoc()): ?>
                            <option value="<?php echo $fornecedor['id']; ?>"><?php echo $fornecedor['nome']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="descricao" class="block text-gray-700">Descrição</label>
                    <input type="text" name="descricao" required class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div class="mb-4">
                    <label for="valor" class="block text-gray-700">Valor</label>
                    <input type="number" name="valor" step="0.01" required class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div class="mb-4">
                    <label for="data_vencimento" class="block text-gray-700">Data de Vencimento</label>
                    <input type="date" name="data_vencimento" required class="w-full px-4 py-2 border rounded-lg">
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">Adicionar Conta</button>
            </form>
        </div>
    </div>
</body>
</html>
