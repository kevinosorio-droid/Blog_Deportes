<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog_deportes-main";

// Crear conexión
$db = mysqli_connect($servername, $username, $password, $dbname);

// Verificar conexión
if (!$db) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>