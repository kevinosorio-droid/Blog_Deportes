<?php
// buscar.php

// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("conexion.php");

// Verificar conexión
if (!$conn) {
    die("<div class='alerta-error'>Error: No se pudo conectar a la base de datos. " . mysqli_connect_error() . "</div>");
}

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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de la Búsqueda - Blog de Temas</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include("../includes/header.php"); ?>
    <div id="contenedor">
        <div id="principal">
            <h1>Resultados de la Búsqueda</h1>

            <?php if (isset($mensaje_error)): ?>
                <div class="alerta-error"><?php echo $mensaje_error; ?></div>
            <?php endif; ?>

            <?php if ($resultados): ?>
                <?php if (mysqli_num_rows($resultados) > 0): ?>
                    <?php while ($entrada = mysqli_fetch_assoc($resultados)): ?>
                        <article class="entrada">
                            <h2><?php echo htmlspecialchars($entrada['titulo']); ?></h2>
                            <span class="fecha"><?php echo $entrada['fecha']; ?> | <?php echo htmlspecialchars($entrada['autor']); ?> | <?php echo htmlspecialchars($entrada['categoria_nombre']); ?></span>
                            <p><?php echo htmlspecialchars($entrada['resumen']) . '...'; ?></p>
                            <a href="entrada.php?id=<?php echo $entrada['id']; ?>" class="boton">Leer más</a>
                        </article>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No se encontraron entradas que coincidan con su búsqueda.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php include("../includes/sidebar.php"); ?>
    </div>
    <?php include("../includes/footer.php"); ?>
    <script src="../js/auth.js"></script>
</body>
</html>

<?php mysqli_close($conn); ?>