<?php
session_start();
include('../../includes/database.php');
include('../../includes/auth.php');

// Verificar se o ID da fatura foi fornecido
if (isset($_GET['id'])) {
    $fatura_id = $_GET['id'];

    // Excluir a fatura
    $sql = "DELETE FROM contas_receber WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $fatura_id);

    if ($stmt->execute()) {
        header("Location: listar_contas_receber.php");
        exit();
    } else {
        echo "Erro ao excluir a fatura: " . $conn->error;
    }
} else {
    echo "ID da fatura não fornecido.";
}
?>
