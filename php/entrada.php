<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("php/conexion.php");

// Obtener el ID de la entrada
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Buscar la entrada en la base de datos
$sql = "SELECT * FROM entradas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$entrada = $resultado->fetch_assoc();

$stmt->close();
$conn->close();

// Verificar si la entrada existe
if (!$entrada) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($entrada['titulo']); ?></title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Incluir la cabecera -->
    <?php include("includes/header.php"); ?>

    <!-- Contenido principal -->
    <div id="contenido-principal">
        <h1><?php echo htmlspecialchars($entrada['titulo']); ?></h1>
        <p><?php echo htmlspecialchars($entrada['descripcion']); ?></p>
        <div><?php echo nl2br(htmlspecialchars($entrada['contenido'])); ?></div>
        <p><small>Publicado el: <?php echo date("d/m/Y H:i", strtotime($entrada['fecha'])); ?></small></p>
    </div>

    <!-- Incluir la barra lateral -->
    <?php include("includes/sidebar.php"); ?>

    <!-- Incluir el pie de página -->
    <?php include("includes/footer.php"); ?>
</body>
</html>