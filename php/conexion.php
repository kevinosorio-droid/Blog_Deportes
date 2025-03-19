<?php
$servername = "localhost"; // Servidor de la base de datos
$username = "root";        // Nombre de usuario de MySQL
$password = "";            // Contraseña de MySQL
$dbname = "blog_deportes-main"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>