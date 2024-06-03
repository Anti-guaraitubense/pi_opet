<?php 
    $serverName = "127.0.0.1:3306"; // nome do servidor SQL
    $database = "doasans"; // nome do banco de dados
    $username = "root"; // nome de usuário
    $password = "root"; // senha

    $conn = new PDO("mysql:host=$serverName;dbname=$database", "$username", "$password");
?>