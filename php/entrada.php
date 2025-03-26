<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("conexion.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $entrada_id = $_GET['id'];

    $sql = "SELECT e.id, e.usuario_id, e.categoria_id, e.titulo, e.descripcion AS contenido, 
                   DATE_FORMAT(e.fecha, '%d/%m/%Y %H:%i') AS fecha, 
                   c.nombre AS categoria_nombre, 
                   u.nombre AS autor
            FROM entradas e
            INNER JOIN categorias c ON e.categoria_id = c.id
            INNER JOIN usuarios u ON e.usuario_id = u.id
            WHERE e.id = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $entrada_id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($resultado) == 1) {
            $entrada = mysqli_fetch_assoc($resultado);
        } else {
            header("Location: ../index.php?error=entrada_no_encontrada");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
} else {
    header("Location: ../index.php?error=id_invalido");
    exit();
}

if (isset($_GET['eliminar']) && $_GET['eliminar'] == 'true' && isset($_SESSION['usuario'])) {
    $sql_delete = "DELETE FROM entradas WHERE id = ?";

    if ($stmt = mysqli_prepare($conn, $sql_delete)) {
        mysqli_stmt_bind_param($stmt, "i", $entrada_id);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['mensaje'] = "Entrada eliminada con éxito.";
            $_SESSION['tipo_mensaje'] = 'success';
            header("Location: ../index.php");
            exit();
        } else {
            $_SESSION['mensaje'] = "Error al eliminar la entrada: " . mysqli_error($conn);
            $_SESSION['tipo_mensaje'] = 'danger';
            header("Location: entrada.php?id=" . $entrada_id);
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($entrada['titulo'] ?? 'Título no disponible'); ?> - Blog de Temas</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include("../includes/header.php"); ?>

    <div id="contenedor">
        <div id="principal">
            <article class="entrada-completa">
                <h1><?php echo htmlspecialchars($entrada['titulo'] ?? 'Título no disponible'); ?></h1>
                <span class="fecha"><?php echo $entrada['fecha'] ?? 'Fecha desconocida'; ?> | 
                <?php echo htmlspecialchars($entrada['autor'] ?? 'Autor desconocido'); ?> | 
                <?php echo htmlspecialchars($entrada['categoria_nombre'] ?? 'Categoría desconocida'); ?></span>
                <p><?php echo nl2br(htmlspecialchars($entrada['contenido'] ?? 'Contenido no disponible')); ?></p>

                <?php if (isset($_SESSION['usuario'])): ?>
                    <div class="acciones">
                        <a href="editar_entrada.php?id=<?php echo $entrada['id']; ?>" class="boton boton-editar">Editar</a>
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
