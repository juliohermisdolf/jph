<?php
// database.php
$servername = "localhost";
$username = "root";
$password = "";  // deixe vazio se você não configurou senha para o MySQL
$dbname = "advocacia";  // o nome do banco que criamos no phpMyAdmin

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
