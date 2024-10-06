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

    // Preparar e executar a consulta de exclusão
    $sql = "DELETE FROM clientes WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $cliente_id);
        if ($stmt->execute()) {
            // Redirecionar de volta à lista de clientes após a exclusão
            header("Location: listar_clientes.php");
            exit();
        } else {
            echo "<p class='text-red-500'>Erro ao excluir o cliente: " . $stmt->error . "</p>";
        }
    } else {
        echo "<p class='text-red-500'>Erro na preparação da consulta SQL: " . $conn->error . "</p>";
    }
} else {
    echo "<p class='text-red-500'>ID de cliente não fornecido.</p>";
    exit();
}
?>
