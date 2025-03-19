<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("php/conexion.php"); // Asegúrate de que la ruta sea correcta

// Verificar si la conexión a la base de datos se estableció correctamente
if (!$conn) {
    echo "<div class='alerta-error'>Error: No se pudo conectar a la base de datos. " . mysqli_connect_error() . "</div>";
    // Detener la ejecución del script si la conexión falla
    exit;
}

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $usuario_id = $_SESSION['usuario']['id']; // Obtener ID de usuario
}

// Procesar el formulario de creación de entradas si se envía
if (isset($_POST['crear_entrada']) && isset($_SESSION['usuario'])) {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $categoria_id = $_POST['categoria'];

    $sql = "INSERT INTO entradas (usuario_id, categoria_id, titulo, contenido, fecha) VALUES ($usuario_id, $categoria_id, '$titulo', '$contenido', CURDATE())";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alerta'>Entrada creada con éxito.</div>";
    } else {
        echo "<div class='alerta-error'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</div>";
    }
}

// Obtener categorías para el select
$categorias = mysqli_query($conn, "SELECT * FROM categorias");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Blog de Temas</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include("includes/header.php"); ?>

    <div id="contenedor">
        <div id="principal">
            <?php if (isset($_SESSION['usuario']) && isset($_GET['crear_entrada'])): ?>
                <h1>Crear Nueva Entrada</h1>
                <form action="index.php" method="POST">
                    <label for="titulo">Título:</label>
                    <input type="text" name="titulo" required />

                    <label for="contenido">Contenido:</label>
                    <textarea name="contenido" rows="10" required></textarea>

                    <label for="categoria">Categoría:</label>
                    <select name="categoria">
                        <?php while ($categorias && $categoria = mysqli_fetch_assoc($categorias)): ?>
                            <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                        <?php endwhile; ?>
                    </select>

                    <input type="submit" name="crear_entrada" value="Guardar Entrada" class="boton boton-verde" />
                </form>
            <?php else: ?>
                <h1>Bienvenido al Blog</h1>
                <p>Este es el contenido principal de la página.</p>
            <?php endif; ?>
        </div>

        <?php include("includes/sidebar.php"); ?>
    </div>

    <?php include("includes/footer.php"); ?>

    <script src="js/auth.js"></script>
</body>
</html>