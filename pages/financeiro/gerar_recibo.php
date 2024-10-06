<?php
session_start();
include('../../includes/database.php');
include('../../includes/auth.php');

// Adicionar Recibo
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $data_emissao = date('Y-m-d');  // Data atual

    // Inserir recibo no banco de dados
    $sql = "INSERT INTO recibos_avulsos (cliente_id, descricao, valor, data_emissao) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isds", $cliente_id, $descricao, $valor, $data_emissao);
    if ($stmt->execute()) {
        header("Location: listar_recibos.php");
        exit();
    } else {
        echo "Erro ao gerar recibo: " . $conn->error;
    }
}

// Consultar os clientes para o formulário
$sql_clientes = "SELECT id, nome FROM clientes";
$result_clientes = $conn->query($sql_clientes);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Recibo Avulso</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center">Gerar Recibo Avulso</h2>

            <form action="gerar_recibo.php" method="POST">
                <div class="mb-4">
                    <label for="cliente_id" class="block text-gray-700">Cliente</label>
                    <select name="cliente_id" class="w-full px-4 py-2 border rounded-lg" required>
                        <?php while ($cliente = $result_clientes->fetch_assoc()): ?>
                            <option value="<?php echo $cliente['id']; ?>"><?php echo $cliente['nome']; ?></option>
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

                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">Gerar Recibo</button>
            </form>
        </div>
    </div>
</body>
</html>
