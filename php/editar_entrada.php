<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT id, titulo, descripcion, categoria_id FROM entradas WHERE id = $id";
    $resultado = mysqli_query($conn, $sql);
    if (mysqli_num_rows($resultado) == 1) {
        $entrada = mysqli_fetch_assoc($resultado);
    } else {
        $_SESSION['mensaje'] = "Entrada no encontrada.";
        $_SESSION['tipo_mensaje'] = 'warning';
        header("Location: ../index.php");
        exit();
    }
} else {
    $_SESSION['mensaje'] = "ID de entrada no válido.";
    $_SESSION['tipo_mensaje'] = 'warning';
    header("Location: ../index.php");
    exit();
}

$categorias_query = mysqli_query($conn, "SELECT id, nombre FROM categorias");
$categorias = mysqli_fetch_all($categorias_query, MYSQLI_ASSOC);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Entrada</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include("../includes/header.php"); ?>
    <div id="contenedor">
        <div id="principal">
            <h1>Editar Entrada</h1>
            <form action="actualizar_entrada.php" method="POST">
                <input type="hidden" name="entrada_id" value="<?php echo $entrada['id']; ?>">
                <label for="titulo">Título:</label>
                <input type="text" name="titulo" value="<?php echo htmlspecialchars($entrada['titulo']); ?>" required />
                <label for="contenido">Contenido:</label>
                <textarea name="contenido" rows="10" required><?php echo htmlspecialchars($entrada['descripcion']); ?></textarea>
                <label for="categoria">Categoría:</label>
                <select name="categoria">
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php if ($cat['id'] == $entrada['categoria_id']) echo 'selected'; ?>><?php echo htmlspecialchars($cat['nombre']); ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" name="actualizar_entrada" value="Guardar Cambios" class="boton boton-verde" />
                <a href="entrada.php?id=<?php echo $entrada['id']; ?>" class="boton">Cancelar</a>
            </form>
        </div>
        <?php include("../includes/sidebar.php"); ?>
    </div>
    <?php include("../includes/footer.php"); ?>
</body>
</html>
<?php
mysqli_close($conn);
?>