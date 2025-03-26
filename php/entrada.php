<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("conexion.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $entrada_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Consulta SQL MODIFICADA para seleccionar 'descripcion' con el alias 'contenido'
    $sql = "SELECT e.id, e.usuario_id, e.categoria_id, e.titulo, e.descripcion AS contenido, DATE_FORMAT(e.fecha, '%d/%m/%Y %H:%i') AS fecha, c.nombre AS categoria_nombre, u.nombre AS autor
            FROM entradas e
            INNER JOIN categorias c ON e.categoria_id = c.id
            INNER JOIN usuarios u ON e.usuario_id = u.id
            WHERE e.id = $entrada_id";
    $resultado = mysqli_query($conn, $sql);

    if (mysqli_num_rows($resultado) == 1) {
        $entrada = mysqli_fetch_assoc($resultado);
    } else {
        header("Location: ../index.php?error=entrada_no_encontrada");
        exit();
    }
} else {
    header("Location: ../index.php?error=id_invalido");
    exit();
}

// --- PROCESAMIENTO DE ELIMINACIÓN (Si se hace desde esta página) ---
if (isset($_GET['eliminar']) && $_GET['eliminar'] == 'true' && isset($_SESSION['usuario'])) {
    $delete_id = mysqli_real_escape_string($conn, $entrada_id); // Usamos el ID de la entrada actual

    $sql_delete = "DELETE FROM entradas WHERE id = $delete_id";

    if (mysqli_query($conn, $sql_delete)) {
        $_SESSION['mensaje'] = "Entrada eliminada con éxito.";
        $_SESSION['tipo_mensaje'] = 'success';
        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION['mensaje'] = "Error al eliminar la entrada: " . mysqli_error($conn);
        $_SESSION['tipo_mensaje'] = 'danger';
        header("Location: entrada.php?id=" . $entrada_id); // Volver a la misma página con error
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($entrada['titulo']); ?> - Blog de Temas</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include("../includes/header.php"); ?>

    <div id="contenedor">
        <div id="principal">
            <article class="entrada-completa">
                <h1><?php echo htmlspecialchars($entrada['titulo']); ?></h1>
                <span class="fecha"><?php echo $entrada['fecha']; ?> | <?php echo htmlspecialchars($entrada['autor']); ?> | <?php echo htmlspecialchars($entrada['categoria_nombre']); ?></span>
                <p><?php echo nl2br(htmlspecialchars($entrada['contenido'])); ?></p>

                <?php if (isset($_SESSION['usuario'])): ?>
                    <div class="acciones">
                        <a href="editar.php?id=<?php echo $entrada['id']; ?>" class="boton boton-editar">Editar</a>
                        <a href="entrada.php?id=<?php echo $entrada['id']; ?>&eliminar=true" class="boton boton-eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar esta entrada?')">Eliminar</a>
                    </div>
                <?php endif; ?>
            </article>
        </div>

        <?php include("../includes/sidebar.php"); ?>
    </div>

    <?php include("../includes/footer.php"); ?>
</body>
</html>
<?php
mysqli_close($conn);
?>