<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("php/conexion.php"); // Asegúrate de que la ruta sea correcta

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Blog de Temas</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Incluir la cabecera -->
    <?php include("includes/header.php"); ?>

    <!-- Contenido principal -->
    <div id="contenido-principal">
        <h1>Bienvenido al Blog</h1>
        <p>Este es el contenido principal de la página.</p>
    </div>

    <!-- Incluir la barra lateral -->
    <?php include("includes/sidebar.php"); ?>

    <!-- Incluir el pie de página -->
    <?php include("includes/footer.php"); ?>

    <script src="js/auth.js"></script>
</body>
</html>