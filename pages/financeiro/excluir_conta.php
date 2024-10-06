<?php
session_start();
include('../../includes/database.php');
include('../../includes/auth.php');

// Verificar se o ID da conta foi fornecido
if (isset($_GET['id'])) {
    $conta_id = $_GET['id'];

    // Excluir a conta
    $sql = "DELETE FROM contas_pagar WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $conta_id);

    if ($stmt->execute()) {
        header("Location: listar_contas_pagar.php");
        exit();
    } else {
        echo "Erro ao excluir a conta: " . $conn->error;
    }
} else {
    echo "ID da conta não fornecido.";
}
?>
