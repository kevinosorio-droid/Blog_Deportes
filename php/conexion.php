<?php
$servername = "localhost"; // Servidor de la base de datos
$username = "root";
$password = "";
$dbname = "blog_deportes-main";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

?>