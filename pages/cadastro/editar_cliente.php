<?php
session_start();
include('../../includes/database.php');

// Verificar se o usuário está logado
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../../login.php');
    exit();
}

// Verificar se o ID de cliente foi fornecido
if (isset($_GET['id'])) {
    $cliente_id = $_GET['id'];

    // Buscar os dados do cliente
    $sql = "SELECT * FROM clientes WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $cliente_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar se o cliente existe e preencher a variável $cliente
        if ($result->num_rows > 0) {
            $cliente = $result->fetch_assoc();
        } else {
            echo "<p class='text-red-500'>Cliente não encontrado.</p>";
            exit();
        }
    } else {
        echo "<p class='text-red-500'>Erro na preparação da consulta SQL: " . $conn->error . "</p>";
        exit();
    }
} else {
    echo "<p class='text-red-500'>ID de cliente não fornecido.</p>";
    exit();
}

// Atualizar os dados do cliente quando o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura e validação dos dados recebidos
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $sobrenome = isset($_POST['sobrenome']) ? $_POST['sobrenome'] : '';
    $prenome = isset($_POST['prenome']) ? $_POST['prenome'] : '';
    $nacionalidade = isset($_POST['nacionalidade']) ? $_POST['nacionalidade'] : '';
    $estado_civil = isset($_POST['estado_civil']) ? $_POST['estado_civil'] : '';
    $profissao = isset($_POST['profissao']) ? $_POST['profissao'] : '';
    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
    $rg = isset($_POST['rg']) ? $_POST['rg'] : '';
    $orgao_expedidor = isset($_POST['orgao_expedidor']) ? $_POST['orgao_expedidor'] : '';
    $data_nascimento = isset($_POST['data_nascimento']) ? $_POST['data_nascimento'] : '';
    $nome_pai = isset($_POST['nome_pai']) ? $_POST['nome_pai'] : '';
    $nome_mae = isset($_POST['nome_mae']) ? $_POST['nome_mae'] : '';
    $naturalidade = isset($_POST['naturalidade']) ? $_POST['naturalidade'] : '';
    $endereco = isset($_POST['endereco']) ? $_POST['endereco'] : '';
    $numero = isset($_POST['numero']) ? $_POST['numero'] : ''; 
    $bairro = isset($_POST['bairro']) ? $_POST['bairro'] : '';
    $complemento = isset($_POST['complemento']) ? $_POST['complemento'] : '';
    $municipio = isset($_POST['municipio']) ? $_POST['municipio'] : '';
    $cep = isset($_POST['cep']) ? $_POST['cep'] : '';
    $estado = isset($_POST['estado']) ? $_POST['estado'] : '';
    $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';

    // SQL para atualizar o cliente
    $sql = "UPDATE clientes SET 
        nome = ?, sobrenome = ?, prenome = ?, nacionalidade = ?, estado_civil = ?, profissao = ?, cpf = ?, rg = ?, orgao_expedidor = ?, data_nascimento = ?, nome_pai = ?, nome_mae = ?, naturalidade = ?, endereco = ?, numero = ?, bairro = ?, complemento = ?, municipio = ?, cep = ?, estado = ?, telefone = ? 
        WHERE id = ?";

    // Preparando a string de parâmetros e vinculando as variáveis
    if ($stmt = $conn->prepare($sql)) {
        // Corrigindo a string de tipos para 21 's' e 1 'i'
        $stmt->bind_param("sssssssssssssssssssssi", 
            $nome, 
            $sobrenome, 
            $prenome, 
            $nacionalidade, 
            $estado_civil, 
            $profissao, 
            $cpf, 
            $rg, 
            $orgao_expedidor, 
            $data_nascimento, 
            $nome_pai, 
            $nome_mae, 
            $naturalidade, 
            $endereco, 
            $numero, 
            $bairro, 
            $complemento, 
            $municipio, 
            $cep, 
            $estado, 
            $telefone, 
            $cliente_id
        );

        // Executando a atualização e redirecionando após o sucesso
        if ($stmt->execute()) {
            header("Location: clientes.php");
            exit();
        } else {
            echo "<p class='text-red-500'>Erro ao atualizar cliente: " . $stmt->error . "</p>";
        }
    } else {
        echo "<p class='text-red-500'>Erro na preparação da consulta SQL: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-3xl">
            <h2 class="text-2xl font-bold mb-6 text-center">Editar Cliente</h2>
            <form action="editar_cliente.php?id=<?php echo $cliente_id; ?>" method="POST" class="space-y-4 grid grid-cols-2 gap-4">
                
                <!-- Nome Completo -->
                <div>
                    <label for="nome" class="block text-gray-700">Nome</label>
                    <input type="text" name="nome" value="<?php echo isset($cliente['nome']) ? $cliente['nome'] : ''; ?>" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="sobrenome" class="block text-gray-700">Sobrenome</label>
                    <input type="text" name="sobrenome" value="<?php echo isset($cliente['sobrenome']) ? $cliente['sobrenome'] : ''; ?>" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="prenome" class="block text-gray-700">Prenome</label>
                    <input type="text" name="prenome" value="<?php echo isset($cliente['prenome']) ? $cliente['prenome'] : ''; ?>" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Nacionalidade, Estado Civil e Profissão -->
                <div>
                    <label for="nacionalidade" class="block text-gray-700">Nacionalidade</label>
                    <input type="text" name="nacionalidade" value="<?php echo isset($cliente['nacionalidade']) ? $cliente['nacionalidade'] : ''; ?>" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="estado_civil" class="block text-gray-700">Estado Civil</label>
                    <select name="estado_civil" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Solteiro(a)" <?php if ($cliente['estado_civil'] == 'Solteiro(a)') echo 'selected'; ?>>Solteiro(a)</option>
                        <option value="Casado(a)" <?php if ($cliente['estado_civil'] == 'Casado(a)') echo 'selected'; ?>>Casado(a)</option>
                        <option value="Divorciado(a)" <?php if ($cliente['estado_civil'] == 'Divorciado(a)') echo 'selected'; ?>>Divorciado(a)</option>
                        <option value="Viúvo(a)" <?php if ($cliente['estado_civil'] == 'Viúvo(a)') echo 'selected'; ?>>Viúvo(a)</option>
                        <option value="União Estável" <?php if ($cliente['estado_civil'] == 'União Estável') echo 'selected'; ?>>União Estável</option>
                    </select>
                </div>
                <div>
                    <label for="profissao" class="block text-gray-700">Profissão</label>
                    <input type="text" name="profissao" value="<?php echo isset($cliente['profissao']) ? $cliente['profissao'] : ''; ?>" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- CPF e RG -->
                <div>
                    <label for="cpf" class="block text-gray-700">CPF</label>
                    <input type="text" name="cpf" value="<?php echo isset($cliente['cpf']) ? $cliente['cpf'] : ''; ?>" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="rg" class="block text-gray-700">RG</label>
                    <input type="text" name="rg" value="<?php echo isset($cliente['rg']) ? $cliente['rg'] : ''; ?>" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="orgao_expedidor" class="block text-gray-700">Órgão Expedidor</label>
                    <input type="text" name="orgao_expedidor" value="<?php echo isset($cliente['orgao_expedidor']) ? $cliente['orgao_expedidor'] : ''; ?>" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Telefone -->
                <div>
                    <label for="telefone" class="block text-gray-700">Telefone</label>
                    <input type="text" name="telefone" value="<?php echo isset($cliente['telefone']) ? $cliente['telefone'] : ''; ?>" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Data de Nascimento e Nomes dos Pais -->
                <div>
                    <label for="data_nascimento" class="block text-gray-700">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" value="<?php echo isset($cliente['data_nascimento']) ? $cliente['data_nascimento'] : ''; ?>" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="nome_pai" class="block text-gray-700">Nome do Pai</label>
                    <input type="text" name="nome_pai" value="<?php echo isset($cliente['nome_pai']) ? $cliente['nome_pai'] : ''; ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="nome_mae" class="block text-gray-700">Nome da Mãe</label>
                    <input type="text" name="nome_mae" value="<?php echo isset($cliente['nome_mae']) ? $cliente['nome_mae'] : ''; ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Naturalidade -->
                <div>
                    <label for="naturalidade" class="block text-gray-700">Naturalidade (Cidade e Estado)</label>
                    <input type="text" name="naturalidade" value="<?php echo isset($cliente['naturalidade']) ? $cliente['naturalidade'] : ''; ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Endereço Completo -->
                <div>
                    <label for="endereco" class="block text-gray-700">Logradouro</label>
                    <input type="text" name="endereco" value="<?php echo isset($cliente['endereco']) ? $cliente['endereco'] : ''; ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="numero" class="block text-gray-700">Número</label>
                    <input type="text" name="numero" value="<?php echo isset($cliente['numero']) ? $cliente['numero'] : ''; ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="bairro" class="block text-gray-700">Bairro</label>
                    <input type="text" name="bairro" value="<?php echo isset($cliente['bairro']) ? $cliente['bairro'] : ''; ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="complemento" class="block text-gray-700">Complemento</label>
                    <input type="text" name="complemento" value="<?php echo isset($cliente['complemento']) ? $cliente['complemento'] : ''; ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="municipio" class="block text-gray-700">Município</label>
                    <input type="text" name="municipio" value="<?php echo isset($cliente['municipio']) ? $cliente['municipio'] : ''; ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="cep" class="block text-gray-700">CEP</label>
                    <input type="text" name="cep" value="<?php echo isset($cliente['cep']) ? $cliente['cep'] : ''; ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="estado" class="block text-gray-700">Estado</label>
                    <input type="text" name="estado" value="<?php echo isset($cliente['estado']) ? $cliente['estado'] : ''; ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Botão para Submeter -->
                <div class="col-span-2">
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">Atualizar Cliente</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
