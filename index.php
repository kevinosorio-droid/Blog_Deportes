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

// Procesar el formulario de creación de categorías
if (isset($_POST['crear_categoria']) && isset($_SESSION['usuario'])) {
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre_categoria']);
    
    // Comprobar si la categoría ya existe
    $sql_check = "SELECT * FROM categorias WHERE nombre = '$nombre'";
    $check = mysqli_query($conn, $sql_check);
    
    if(mysqli_num_rows($check) > 0){
        echo "<div class='alerta-error'>La categoría '$nombre' ya existe</div>";
    } else {
        // Insertar la categoría
        $sql = "INSERT INTO categorias (nombre) VALUES ('$nombre')";
        if(mysqli_query($conn, $sql)){
            echo "<div class='alerta'>Categoría creada con éxito.</div>";
        } else {
            echo "<div class='alerta-error'>Error al crear la categoría: " . mysqli_error($conn) . "</div>";
        }
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
            <?php elseif (isset($_SESSION['usuario']) && isset($_GET['crear_categoria'])): ?>
                <h1>Crear Nueva Categoría</h1>
                <form action="index.php" method="POST">
                    <label for="nombre_categoria">Nombre de la categoría:</label>
                    <input type="text" name="nombre_categoria" required />
                    
                    <input type="submit" name="crear_categoria" value="Guardar Categoría" class="boton boton-verde" />
                </form>
            <?php else: ?>
                <h1>Bienvenido al Blog</h1>
                <?php
                // Obtener entradas filtradas por categoría si se seleccionó una
                if(isset($_GET['categoria'])) {
                    $categoria_id = (int)$_GET['categoria'];
                    $sql = "SELECT e.*, c.nombre as categoria_nombre, u.nombre as autor 
                            FROM entradas e 
                            INNER JOIN categorias c ON e.categoria_id = c.id 
                            INNER JOIN usuarios u ON e.usuario_id = u.id 
                            WHERE e.categoria_id = $categoria_id 
                            ORDER BY e.fecha DESC";
                    $categoria_actual = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nombre FROM categorias WHERE id = $categoria_id"));
                    echo "<h2>Entradas de la categoría: " . $categoria_actual['nombre'] . "</h2>";
                } else {
                    $sql = "SELECT e.*, c.nombre as categoria_nombre, u.nombre as autor 
                            FROM entradas e 
                            INNER JOIN categorias c ON e.categoria_id = c.id 
                            INNER JOIN usuarios u ON e.usuario_id = u.id 
                            ORDER BY e.fecha DESC";
                }

                $entradas = mysqli_query($conn, $sql);
                
                if($entradas && mysqli_num_rows($entradas) > 0):
                    while($entrada = mysqli_fetch_assoc($entradas)):
                ?>
                    <article class="entrada">
                        <h2><?php echo $entrada['titulo']; ?></h2>
                        <span class="fecha"><?php echo date('d/m/Y', strtotime($entrada['fecha'])); ?> | <?php echo $entrada['autor']; ?> | <?php echo $entrada['categoria_nombre']; ?></span>
                        <p><?php echo substr($entrada['contenido'], 0, 200) . '...'; ?></p>
                        <a href="entrada.php?id=<?php echo $entrada['id']; ?>" class="boton">Leer más</a>
                    </article>
                <?php 
                    endwhile;
                else:
                    echo "<p>No hay entradas para mostrar.</p>";
                endif;
                ?>
            <?php endif; ?>
        </div>

        <?php include("includes/sidebar.php"); ?>
    </div>

    <?php include("includes/footer.php"); ?>

    <script src="js/auth.js"></script>
</body>
</html>