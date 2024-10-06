<?php
session_start();
include('../../includes/database.php');

// Verificar se o usuário está logado
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar os dados do formulário
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $prenome = $_POST['prenome'];
    $nacionalidade = $_POST['nacionalidade'];
    $estado_civil = $_POST['estado_civil'];
    $profissao = $_POST['profissao'];
    $cpf = $_POST['cpf'];
    $rg = $_POST['rg'];
    $orgao_expedidor = $_POST['orgao_expedidor'];
    $data_nascimento = $_POST['data_nascimento'];
    $nome_pai = $_POST['nome_pai'];
    $nome_mae = $_POST['nome_mae'];
    $naturalidade = $_POST['naturalidade'];
    $endereco = $_POST['endereco'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $complemento = $_POST['complemento'];
    $municipio = $_POST['municipio'];
    $cep = $_POST['cep'];
    $estado = $_POST['estado'];
    $telefone = $_POST['telefone'];  // Campo Telefone

    // Inserir o cliente no banco de dados
    $sql = "INSERT INTO clientes (nome, sobrenome, prenome, nacionalidade, estado_civil, profissao, cpf, rg, orgao_expedidor, data_nascimento, nome_pai, nome_mae, naturalidade, endereco, numero, bairro, complemento, municipio, cep, estado, telefone) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssssssssssss", 
        $nome, $sobrenome, $prenome, $nacionalidade, $estado_civil, $profissao, $cpf, $rg, $orgao_expedidor, $data_nascimento, 
        $nome_pai, $nome_mae, $naturalidade, $endereco, $numero, $bairro, $complemento, $municipio, $cep, $estado, $telefone);

    if ($stmt->execute()) {
        header("Location: clientes.php");
        exit();
    } else {
        echo "<p class='text-red-500'>Erro ao adicionar cliente: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Cliente</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-3xl">
            <h2 class="text-2xl font-bold mb-6 text-center">Adicionar Cliente</h2>
            <form action="adicionar_cliente.php" method="POST" class="space-y-4 grid grid-cols-2 gap-4">
                
                <!-- Nome Completo -->
                <div>
                    <label for="nome" class="block text-gray-700">Nome</label>
                    <input type="text" name="nome" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="sobrenome" class="block text-gray-700">Sobrenome</label>
                    <input type="text" name="sobrenome" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="prenome" class="block text-gray-700">Prenome</label>
                    <input type="text" name="prenome" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Nacionalidade, Estado Civil e Profissão -->
                <div>
                    <label for="nacionalidade" class="block text-gray-700">Nacionalidade</label>
                    <input type="text" name="nacionalidade" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="estado_civil" class="block text-gray-700">Estado Civil</label>
                    <select name="estado_civil" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Solteiro(a)">Solteiro(a)</option>
                        <option value="Casado(a)">Casado(a)</option>
                        <option value="Divorciado(a)">Divorciado(a)</option>
                        <option value="Viúvo(a)">Viúvo(a)</option>
                        <option value="União Estável">União Estável</option>
                    </select>
                </div>
                <div>
                    <label for="profissao" class="block text-gray-700">Profissão</label>
                    <input type="text" name="profissao" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- CPF, RG e Telefone -->
                <div>
                    <label for="cpf" class="block text-gray-700">CPF</label>
                    <input type="text" name="cpf" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="rg" class="block text-gray-700">RG</label>
                    <input type="text" name="rg" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="orgao_expedidor" class="block text-gray-700">Órgão Expedidor</label>
                    <input type="text" name="orgao_expedidor" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="telefone" class="block text-gray-700">Telefone</label>
                    <input type="text" name="telefone" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Data de Nascimento e Nomes dos Pais -->
                <div>
                    <label for="data_nascimento" class="block text-gray-700">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="nome_pai" class="block text-gray-700">Nome do Pai</label>
                    <input type="text" name="nome_pai" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="nome_mae" class="block text-gray-700">Nome da Mãe</label>
                    <input type="text" name="nome_mae" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Naturalidade -->
                <div>
                    <label for="naturalidade" class="block text-gray-700">Naturalidade (Cidade e Estado)</label>
                    <input type="text" name="naturalidade" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Endereço Completo -->
                <div>
                    <label for="endereco" class="block text-gray-700">Logradouro</label>
                    <input type="text" name="endereco" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="numero" class="block text-gray-700">Número</label>
                    <input type="text" name="numero" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="bairro" class="block text-gray-700">Bairro</label>
                    <input type="text" name="bairro" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="complemento" class="block text-gray-700">Complemento</label>
                    <input type="text" name="complemento" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="municipio" class="block text-gray-700">Município</label>
                    <input type="text" name="municipio" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="cep" class="block text-gray-700">CEP</label>
                    <input type="text" name="cep" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="estado" class="block text-gray-700">Estado</label>
                    <input type="text" name="estado" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Botão para Submeter -->
                <div class="col-span-2">
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">Adicionar Cliente</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
