<?php
$servername = "localhost"; // Servidor de la base de datos
$username = "root";        // Nombre de usuario de MySQL
$password = "";            // Contraseña de MySQL
$dbname = "nombre_de_tu_base_de_datos"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname , $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>