<?php
session_start();
include("conexion.php");

if (isset($_SESSION['usuario'])) {
    // Usuario ha iniciado sesión
    echo "Bienvenido, " . $_SESSION['usuario']['nombre'];
    echo '<a href="index.php?logout=true">Cerrar sesión</a>';
} else {
    // Mostrar formulario de inicio de sesión y registro
    ?>
    <div id="alerta" class="alerta"></div>
    <form id="loginForm">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Iniciar sesión</button>
    </form>
    <form id="registerForm">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellidos" placeholder="Apellidos" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Registrarse</button>
    </form>
    <?php
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>