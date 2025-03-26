<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['actualizar_entrada'])) {
    $entrada_id = mysqli_real_escape_string($conn, $_POST['entrada_id']);
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $descripcion  = mysqli_real_escape_string($conn, $_POST['descripcion ']);
    $categoria_id = mysqli_real_escape_string($conn, $_POST['categoria']);

    $sql = "UPDATE entradas SET titulo = '$titulo', descripcion = '$descripcion', categoria_id = $categoria_id, fecha = CURDATE() WHERE id = $entrada_id";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['mensaje'] = "Entrada actualizada con éxito.";
        $_SESSION['tipo_mensaje'] = 'success';
        header("Location: entrada.php?id=" . $entrada_id);
        exit();
    } else {
        $_SESSION['mensaje'] = "Error al actualizar la entrada: " . mysqli_error($conn);
        $_SESSION['tipo_mensaje'] = 'danger';
        header("Location: editar_entrada.php?id=" . $entrada_id);
        exit();
    }
} else {
    $_SESSION['mensaje'] = "Solicitud de actualización no válida.";
    $_SESSION['tipo_mensaje'] = 'warning';
    header("Location: ../index.php");
    exit();
}

mysqli_close($conn);
?>