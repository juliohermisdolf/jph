<?php
session_start();
include('../../includes/database.php');
include('../../includes/auth.php');

// Verificar se o ID da despesa foi fornecido
if (isset($_GET['id'])) {
    $despesa_id = $_GET['id'];

    // Excluir a despesa
    $sql = "DELETE FROM despesas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $despesa_id);

    if ($stmt->execute()) {
        header("Location: listar_despesas.php");
        exit();
    } else {
        echo "Erro ao estornar a despesa: " . $conn->error;
    }
} else {
    echo "ID da despesa não fornecido.";
}
?>
