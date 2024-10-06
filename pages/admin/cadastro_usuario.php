<?php
// Ajuste o caminho para acessar o arquivo database.php
include('../../includes/database.php');

session_start();

// Verificar se o usuário está logado e é admin
if (!isset($_SESSION['loggedin']) || $_SESSION['nivel_acesso'] !== 'admin') {
    header('Location: ../../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);  // Criptografar a senha
    $nivel_acesso = $_POST['nivel_acesso'];

    // Inserir o novo usuário no banco de dados
    $sql = "INSERT INTO usuarios (usuario, senha, nivel_acesso) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $usuario, $senha, $nivel_acesso);

    if ($stmt->execute()) {
        echo "<p class='text-green-500'>Usuário cadastrado com sucesso!</p>";
    } else {
        echo "<p class='text-red-500'>Erro ao cadastrar usuário: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Novo Usuário</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center">Cadastrar Novo Usuário</h2>
            <form action="cadastro_usuario.php" method="POST" class="space-y-4">
                <div>
                    <label for="usuario" class="block text-gray-700">Nome de Usuário</label>
                    <input type="text" name="usuario" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="senha" class="block text-gray-700">Senha</label>
                    <input type="password" name="senha" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="nivel_acesso" class="block text-gray-700">Nível de Acesso</label>
                    <select name="nivel_acesso" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="admin">Administrador</option>
                        <option value="advogado">Advogado</option>
                        <option value="secretaria">Secretária</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">Cadastrar Usuário</button>
            </form>
        </div>
    </div>
</body>
</html>
