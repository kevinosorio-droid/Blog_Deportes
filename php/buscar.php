<?php
session_start();
include("../php/conexion.php");
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("php/conexion.php"); // Asegúrate de que la ruta sea correcta

// Obtener el término de búsqueda
$busqueda = isset($_POST['busqueda']) ? trim($_POST['busqueda']) : '';

// Verificar si se envió un término de búsqueda
if (empty($busqueda)) {
    header("Location: index.php");
    exit();
}

// Buscar en la base de datos
$sql = "SELECT * FROM entradas WHERE titulo LIKE ? OR descripcion LIKE ?";
$stmt = $conn->prepare($sql);
$busquedaParam = "%$busqueda%";
$stmt->bind_param("ss", $busquedaParam, $busquedaParam);
$stmt->execute();
$resultado = $stmt->get_result();

// Obtener los resultados
$resultados = [];
while ($fila = $resultado->fetch_assoc()) {
    $resultados[] = $fila;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de búsqueda</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Incluir la cabecera -->
    <?php include("includes/header.php"); ?>

    <!-- Contenido principal -->
    <div id="contenido-principal">
        <h1>Resultados de búsqueda para: "<?php echo htmlspecialchars($busqueda); ?>"</h1>

        <?php if (count($resultados) > 0): ?>
            <!-- Mostrar resultados -->
            <ul>
                <?php foreach ($resultados as $entrada): ?>
                    <li>
                        <h2><?php echo htmlspecialchars($entrada['titulo']); ?></h2>
                        <p><?php echo htmlspecialchars($entrada['descripcion']); ?></p>
                        <p><small>Publicado el: <?php echo date("d/m/Y H:i", strtotime($entrada['fecha'])); ?></small></p>
                        <a href="entrada.php?id=<?php echo $entrada['id']; ?>">Leer más</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <!-- Mostrar mensaje si no hay resultados -->
            <p>No se encontraron resultados para "<?php echo htmlspecialchars($busqueda); ?>".</p>
        <?php endif; ?>
    </div>

    <!-- Incluir la barra lateral -->
    <?php include("includes/sidebar.php"); ?>

    <!-- Incluir el pie de página -->
    <?php include("includes/footer.php"); ?>
</body>
</html>