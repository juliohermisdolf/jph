<?php
session_start();
include('../../includes/database.php');

// Verificar se o usuário está logado
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../../login.php');
    exit();
}

// Verificar se o ID do cliente foi fornecido
if (isset($_GET['id'])) {
    $cliente_id = $_GET['id'];

    // Excluir o cliente do banco de dados
    $sql = "DELETE FROM clientes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cliente_id);

    if ($stmt->execute()) {
        header("Location: clientes.php");
        exit();
    } else {
        echo "<p class='text-red-500'>Erro ao remover cliente: " . $conn->error . "</p>";
    }
} else {
    echo "<p class='text-red-500'>ID de cliente não fornecido.</p>";
    exit();
}
