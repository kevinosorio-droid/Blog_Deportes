<?php
// buscar.php

// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir conexión (usa una sola ruta consistente)
include("conexion.php");

// Obtener el término de búsqueda
if (isset($_GET['termino']) && !empty($_GET['termino'])) {
    $termino = mysqli_real_escape_string($conn, $_GET['termino']);

    // Consulta SQL para buscar entradas que coincidan con el término
    $sql = "SELECT e.id, e.titulo, SUBSTRING(e.descripcion, 1, 200) AS resumen, DATE_FORMAT(e.fecha, '%d/%m/%Y') AS fecha, c.nombre AS categoria_nombre, u.nombre AS autor
            FROM entradas e
            INNER JOIN categorias c ON e.categoria_id = c.id
            INNER JOIN usuarios u ON e.usuario_id = u.id
            WHERE e.titulo LIKE '%$termino%' OR e.descripcion LIKE '%$termino%'
            ORDER BY e.fecha DESC";

    $resultados = mysqli_query($conn, $sql);
} else {
    // Si no se ingresa un término, mostrar un mensaje
    $resultados = false;
    $mensaje_error = "Por favor, ingrese un término de búsqueda.";
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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de búsqueda</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include("../includes/header.php"); ?>
    <?php include("../includes/sidebar.php"); ?>

    <div id="principal">
        <h1>Resultados de búsqueda para: "<?php echo htmlspecialchars($busqueda); ?>"</h1>

        <?php if (count($resultados) > 0): ?>
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
            <p>No se encontraron resultados para "<?php echo htmlspecialchars($busqueda); ?>".</p>
        <?php endif; ?>
    </div>

    

    <?php include("../includes/footer.php"); ?>
</body>
</html>

<?php
// Ahora sí podemos cerrar la conexión, después de todo el HTML
if (isset($conn)) {
    $conn->close();
}
?>
