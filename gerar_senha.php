<?php
// Substitua 'senha123' pela senha que você deseja criar
$senha = "12345";  
$hash = password_hash($senha, PASSWORD_BCRYPT);

// Exibir o hash gerado
echo "Hash da senha: " . $hash;
