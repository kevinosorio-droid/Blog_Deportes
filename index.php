<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("php/conexion.php");

// Verificar si la conexión a la base de datos se estableció correctamente
if (!$conn) {
    echo "<div class='alerta-error'>Error: No se pudo conectar a la base de datos. " . mysqli_connect_error() . "</div>";
    exit;
}

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $usuario_id = $_SESSION['usuario']['id']; // Obtener ID de usuario
}

// Procesar el formulario de creación de entradas si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_entrada']) && isset($_SESSION['usuario'])) {
    $titulo = isset($_POST['titulo']) ? mysqli_real_escape_string($conn, trim($_POST['titulo'])) : '';
    $contenido = isset($_POST['contenido']) ? mysqli_real_escape_string($conn, trim($_POST['contenido'])) : '';
    $categoria_id = isset($_POST['categoria']) ? (int) $_POST['categoria'] : 0;

    if (!empty($titulo) && !empty($contenido) && $categoria_id > 0) {
        $sql = "INSERT INTO entradas (usuario_id, categoria_id, titulo, descripcion, fecha) VALUES ($usuario_id, $categoria_id, '$titulo', '$contenido', CURDATE())";
        
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php?mensaje=entrada_creada");
            exit;
        } else {
            echo "<div class='alerta-error'>Error al crear la entrada: " . mysqli_error($conn) . "</div>";
        }
    } else {
        echo "<div class='alerta-error'>Todos los campos son obligatorios.</div>";
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
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <?php include("includes/header.php"); ?>
    <div id="contenedor">
        <div id="principal">
            <h1>Bienvenido al Blog</h1>
            <?php
            if (isset($_GET['categoria'])) {
                $categoria_id = (int)$_GET['categoria'];
                $categoria_actual = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nombre FROM categorias WHERE id = $categoria_id"));
                $categoria_nombre = $categoria_actual['nombre'] ?? 'Sin categoría';
                
                echo "<h2>Entradas de la categoría: " . htmlspecialchars($categoria_nombre) . "</h2>";
                
                $sql = "SELECT e.id, e.usuario_id, e.categoria_id, e.titulo, e.descripcion AS contenido, e.fecha, c.nombre as categoria_nombre, u.nombre as autor
                        FROM entradas e
                        INNER JOIN categorias c ON e.categoria_id = c.id
                        INNER JOIN usuarios u ON e.usuario_id = u.id
                        WHERE e.categoria_id = $categoria_id
                        ORDER BY e.fecha DESC";
            } else {
                $sql = "SELECT e.id, e.usuario_id, e.categoria_id, e.titulo, e.descripcion AS contenido, e.fecha, c.nombre as categoria_nombre, u.nombre as autor
                        FROM entradas e
                        INNER JOIN categorias c ON e.categoria_id = c.id
                        INNER JOIN usuarios u ON e.usuario_id = u.id
                        ORDER BY e.fecha DESC";
            }

            $entradas = mysqli_query($conn, $sql);

            if ($entradas && mysqli_num_rows($entradas) > 0):
                while ($entrada = mysqli_fetch_assoc($entradas)):
            ?>
                <article class="entrada">
                    <h2><?php echo htmlspecialchars($entrada['titulo'] ?? 'Sin título'); ?></h2>
                    <span class="fecha">
                        <?php echo date('d/m/Y', strtotime($entrada['fecha'])); ?> |
                        <?php echo htmlspecialchars($entrada['autor'] ?? 'Anónimo'); ?> |
                        <?php echo htmlspecialchars($entrada['categoria_nombre'] ?? 'Sin categoría'); ?>
                    </span>
                    <p><?php echo substr(htmlspecialchars($entrada['contenido'] ?? ''), 0, 200) . '...'; ?></p>
                    <a href="php/entrada.php?id=<?php echo $entrada['id']; ?>" class="boton">Leer más</a>
                </article>
            <?php
                endwhile;
            else:
                echo "<p>No hay entradas para mostrar.</p>";
            endif;
            ?>
        </div>
        <?php include("includes/sidebar.php"); ?>
    </div>
    <?php include("includes/footer.php"); ?>
    <script src="js/auth.js"></script>
</body>
</html>
