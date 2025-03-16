<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuarios (usuario, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $usuario, $password);

    if ($stmt->execute()) {
        $_SESSION['registro_exitoso'] = true; // Guardamos en sesión para mostrar mensaje
        header("Location: login.php"); // Redirigimos al login
        exit();
    } else {
        echo "Error al registrar usuario.";
    }
}

?>

