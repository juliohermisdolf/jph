<?php
session_start();
include('../../includes/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $processo_id = $_POST['processo_id'];
    $valor = $_POST['valor'];

    $sql = "INSERT INTO honorarios (processo_id, valor) VALUES ('$processo_id', '$valor')";

    if ($conn->query($sql) === TRUE) {
        echo "Honorário cadastrado com sucesso!";
    } else {
        echo "Erro: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Honorários</title>
</head>
<body>
    <h2>Cadastrar Honorários</h2>
    <form action="orcamento.php" method="POST">
        <label for="processo_id">ID do Processo:</label>
        <input type="text" name="processo_id" required><br>
        <label for="valor">Valor (R$):</label>
        <input type="number" step="0.01" name="valor" required><br>
        <input type="submit" value="Cadastrar Honorários">
    </form>
</body>
</html>
