<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("conexion.php");

// Validar y sanitizar el ID de la entrada
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $entrada_id = intval($_GET['id']);

    // Consulta preparada para obtener la entrada
    $sql = "SELECT e.id, e.usuario_id, e.categoria_id, e.titulo, e.descripcion, 
                   DATE_FORMAT(e.fecha, '%d/%m/%Y %H:%i') AS fecha, 
                   c.nombre AS categoria_nombre, u.nombre AS autor
            FROM entradas e
            INNER JOIN categorias c ON e.categoria_id = c.id
            INNER JOIN usuarios u ON e.usuario_id = u.id
            WHERE e.id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $entrada_id);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) == 1) {
        $entrada = mysqli_fetch_assoc($resultado);
    } else {
        mysqli_close($conn);
        header("Location: ../index.php?error=entrada_no_encontrada");
        exit();
    }
} else {
    mysqli_close($conn);
    header("Location: ../index.php?error=id_invalido");
    exit();
}

// Procesamiento de eliminación con verificación de permisos
if (isset($_GET['eliminar']) && $_GET['eliminar'] == 'true' && isset($_SESSION['usuario'])) {
    $usuario_id = $_SESSION['usuario']['id'];

    // Verificar que el usuario es dueño de la entrada
    $sql_check = "SELECT id FROM entradas WHERE id = ? AND usuario_id = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "ii", $entrada_id, $usuario_id);
    mysqli_stmt_execute($stmt_check);
    $resultado_check = mysqli_stmt_get_result($stmt_check);

    if (mysqli_num_rows($resultado_check) > 0) {
        $sql_delete = "DELETE FROM entradas WHERE id = ?";
        $stmt_delete = mysqli_prepare($conn, $sql_delete);
        mysqli_stmt_bind_param($stmt_delete, "i", $entrada_id);
        mysqli_stmt_execute($stmt_delete);

        $_SESSION['mensaje'] = "Entrada eliminada con éxito.";
        $_SESSION['tipo_mensaje'] = 'success';
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para eliminar esta entrada.";
        $_SESSION['tipo_mensaje'] = 'danger';
    }

    mysqli_close($conn);
    header("Location: ../index.php");
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($entrada) ? htmlspecialchars($entrada['titulo']) : "Entrada no encontrada"; ?> - Blog de Temas</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include("../includes/header.php"); ?>
    <div id="contenedor">
        <div id="principal">
            <?php if (!isset($entrada)) : ?>
                <h2>Error: Entrada no encontrada</h2>
            <?php else : ?>
                <article class="entrada-completa">
                    <h1><?php echo htmlspecialchars($entrada['titulo']); ?></h1>
                    <span class="fecha">
                        <?php echo $entrada['fecha']; ?> | 
                        <?php echo htmlspecialchars($entrada['autor']); ?> | 
                        <a href="../index.php?categoria=<?php echo $entrada['categoria_id']; ?>">
                            <?php echo htmlspecialchars($entrada['categoria_nombre']); ?>
                        </a>
                    </span>
                    <p><?php echo nl2br(htmlspecialchars($entrada['descripcion'])); ?></p>
                    <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['id'] == $entrada['usuario_id']) : ?>
                        <div class="acciones">
                            <a href="editar_entrada.php?id=<?php echo $entrada['id']; ?>" class="boton boton-editar">Editar</a>
                            <a href="entrada.php?id=<?php echo $entrada['id']; ?>&eliminar=true" class="boton boton-eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar esta entrada?')">Eliminar</a>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endif; ?>
        </div>
        <?php include("../includes/sidebar.php"); ?>
    </div>
    <?php include("../includes/footer.php"); ?>
</body>
</html>
