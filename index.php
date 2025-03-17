<?php
session_start();
include("conexion.php");

if (isset($_SESSION['usuario'])) {
    // Usuario ha iniciado sesión
    echo "Bienvenido, " . $_SESSION['usuario']['nombre'];
    echo '<a href="index.php?logout=true">Cerrar sesión</a>';
} else {
    
    
    
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>