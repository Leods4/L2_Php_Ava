<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "locacao_veiculos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}
?>