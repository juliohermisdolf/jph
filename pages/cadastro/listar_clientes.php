<?php
session_start();
include('../../includes/database.php');

// Verificar se o usuário está logado
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../../login.php');
    exit();
}

// Verificar se um termo de busca foi fornecido
$search_term = isset($_GET['search']) ? $_GET['search'] : '';

// Consulta SQL para buscar clientes com base no termo de busca
if ($search_term) {
    $sql = "SELECT id, nome, sobrenome, cpf, telefone FROM clientes WHERE nome LIKE ? OR cpf LIKE ?";
    $search_param = "%" . $search_term . "%";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $search_param, $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT id, nome, sobrenome, cpf, telefone FROM clientes";
    $result = $conn->query($sql);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Clientes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-4xl">
            <h2 class="text-2xl font-bold mb-6 text-center">Clientes Cadastrados</h2>

            <!-- Barra de busca -->
            <form method="GET" action="listar_clientes.php" class="mb-4">
                <input type="text" name="search" placeholder="Buscar por nome ou CPF" value="<?php echo htmlspecialchars($search_term); ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg mt-2">Buscar</button>
            </form>

            <!-- Tabela para exibir clientes -->
            <table class="w-full table-auto bg-white border rounded-lg">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Nome Completo</th>
                        <th class="px-4 py-2 border">CPF</th>
                        <th class="px-4 py-2 border">Telefone</th>
                        <th class="px-4 py-2 border">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="px-4 py-2 border"><?php echo $row['id']; ?></td>
                                <td class="px-4 py-2 border"><?php echo $row['nome'] . ' ' . $row['sobrenome']; ?></td>
                                <td class="px-4 py-2 border"><?php echo $row['cpf']; ?></td>
                                <td class="px-4 py-2 border"><?php echo $row['telefone']; ?></td>
                                <td class="px-4 py-2 border">
                                    <a href="editar_cliente.php?id=<?php echo $row['id']; ?>" class="bg-blue-500 text-white px-4 py-1 rounded-lg">Editar</a>
                                    <a href="excluir_cliente.php?id=<?php echo $row['id']; ?>" class="bg-red-500 text-white px-4 py-1 rounded-lg ml-2" onclick="return confirm('Tem certeza que deseja excluir este cliente?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-4 py-2 text-center text-gray-500">Nenhum cliente encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
