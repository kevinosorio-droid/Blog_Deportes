<?php
session_start();
include("../php/conexion.php");

// Verificar que el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

$usuario_id = $_SESSION['usuario']['id'];
$id = $_GET['id'] ?? 0;

// Buscar la entrada para verificar si el usuario es el autor
$sql = "SELECT usuario_id FROM entradas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$entrada = $resultado->fetch_assoc();

if (!$entrada || $entrada['usuario_id'] != $usuario_id) {
    die("No tienes permiso para eliminar esta entrada.");
}

// Eliminar la entrada
$sql = "DELETE FROM entradas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: ../index.php?msg=Entrada eliminada");
} else {
    echo "Error al eliminar.";
}

$stmt->close();
$conn->close();
?>
