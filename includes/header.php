<?php
// Verificar conexión y establecerla si no existe
if (!isset($conn) || !$conn instanceof mysqli || $conn->connect_error) {
    include(__DIR__."/../php/conexion.php");
}
?>

<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Blog de Temas</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
</head>
<body>
    <header id="cabecera">
        <div id="logo">
            <a href="/BLOG_DEPORTES/index.php">
                Blog de Temas
            </a>
        </div>

        <nav id="menu">
            <ul>
                <li>
                    <a href="/BLOG_DEPORTES/index.php">Inicio</a>
                </li>
                <?php
                // Obtener categorías para el menú
                $categorias_menu = mysqli_query($conn, "SELECT * FROM categorias ORDER BY nombre ASC");
                if($categorias_menu && mysqli_num_rows($categorias_menu) > 0):
                    while($categoria = mysqli_fetch_assoc($categorias_menu)):
                ?>
                    <li>
                        <a href="/BLOG_DEPORTES/index.php?categoria=<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></a>
                    </li>
                <?php
                    endwhile;
                endif;
                ?>
                <li>
                    <a href="/BLOG_DEPORTES/sobre_mi.php">Sobre mí</a>
                </li>
                <li>
                    <a href="/BLOG_DEPORTES/php/contacto.php">Contacto</a>
                </li>
            </ul>
        </nav>

        <div class="clearfix"></div>
    </header>
