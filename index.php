<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.html"); // Redirige si no está autenticado
    exit();
}

$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
</head>
<body>
    <h1>Bienvenido, <?= htmlspecialchars($usuario['nombre']) ?> <?= htmlspecialchars($usuario['apellidos']) ?></h1>
    <p>Tu correo: <?= htmlspecialchars($usuario['email']) ?></p>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
