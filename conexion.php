<?php
$host = "localhost";
$user = "root"; 
$password = ""; 
$database = "blog_deportes-main"; 

$conn = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>
