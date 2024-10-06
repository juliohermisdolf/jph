<?php
session_start();
include('../../includes/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $honorario_id = $_POST['honorario_id'];

    $sql = "UPDATE honorarios SET status = 'estornado' WHERE id = '$honorario_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Honorário estornado com sucesso!";
    } else {
        echo "Erro: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Estornar Honorários</title>
</head>
<body>
    <h2>Estornar Honorários</h2>
    <form action="estorno.php" method="POST">
        <label for="honorario_id">ID do Honorário:</label>
        <input type="text" name="honorario_id" required><br>
        <input type="submit" value="Estornar Honorários">
    </form>
</body>
</html>
