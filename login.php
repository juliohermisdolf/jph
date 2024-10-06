<?php
session_start();
include('includes/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

    // Verificar se o usuário existe no banco de dados
    // Verifique se os nomes das colunas abaixo estão corretos (ex: 'usuario', 'senha', 'nivel_acesso')
    $sql = "SELECT id, usuario, senha, nivel_acesso FROM usuarios WHERE usuario = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('s', $usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verificar a senha (deve estar criptografada no banco de dados)
            if (password_verify($senha, $user['senha'])) {
                // Configurar a sessão
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $user['id'];
                $_SESSION['nome_usuario'] = $user['usuario'];  // Usando 'usuario' como nome
                $_SESSION['nivel_acesso'] = $user['nivel_acesso'];

                // Redirecionar para o painel
                header("Location: index.php");
                exit();
            } else {
                $erro = "Senha incorreta.";
            }
        } else {
            $erro = "Usuário não encontrado.";
        }
    } else {
        $erro = "Erro ao preparar a consulta SQL: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center">Acesso ao Sistema</h2>

            <?php if (isset($erro)): ?>
                <p class="text-red-500 mb-4"><?php echo $erro; ?></p>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="mb-4">
                    <label for="usuario" class="block text-gray-700">Usuário</label>
                    <input type="text" name="usuario" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label for="senha" class="block text-gray-700">Senha</label>
                    <input type="password" name="senha" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">Entrar</button>
            </form>
        </div>
    </div>
</body>
</html>
