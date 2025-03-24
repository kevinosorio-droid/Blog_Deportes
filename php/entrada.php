<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("../php/conexion.php");

// Verificar si el usuario está autenticado
$usuario_id = $_SESSION['usuario']['id'] ?? null;

// Obtener el ID de la entrada
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Buscar la entrada en la base de datos
$sql = "SELECT * FROM entradas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$entrada = $resultado->fetch_assoc();

include("../includes/header.php");

$stmt->close();
$conn->close();

// Verificar si la entrada existe
if (!$entrada) {
    header("Location: index.php");
    exit();
}

// Verificar si el usuario actual es el autor de la entrada
$es_autor = ($usuario_id !== null && $usuario_id == $entrada['usuario_id']);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($entrada['titulo'] ?? 'Sin título'); ?></title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <!-- Contenido principal -->
    <div id="contenido-principal">
        <h1><?php echo htmlspecialchars($entrada['titulo'] ?? 'Sin título'); ?></h1>
        <p><?php echo htmlspecialchars($entrada['descripcion'] ?? 'Sin descripción'); ?></p>
        <div><?php echo nl2br(htmlspecialchars($entrada['contenido'])); ?></div>
        <p><small>Publicado el: <?php echo date("d/m/Y H:i", strtotime($entrada['fecha'])); ?></small></p>

        <!-- Botones de Editar y Eliminar (Solo si es el autor) -->
        <?php if ($es_autor): ?>
            <a href="editar.php?id=<?php echo $entrada['id']; ?>" class="boton boton-azul">Editar</a>
            <a href="eliminar.php?id=<?php echo $entrada['id']; ?>" class="boton boton-rojo" onclick="return confirm('¿Seguro que quieres eliminar esta entrada?');">Eliminar</a>
        <?php endif; ?>
    </div>

    <!-- Incluir la barra lateral -->
    <?php include("../includes/sidebar.php");?>

    <!-- Incluir el pie de página -->
    <?php include("../includes/footer.php");?>
</body>
</html>
