<?php
// Verificar conexión y establecerla si no existe
if (!isset($conn) || !$conn instanceof mysqli || $conn->connect_error) {
    include(__DIR__."/../php/conexion.php");
}

/* var_dump($conn);
if ($conn && $conn->connect_error) {
    echo "Error de conexión: " . $conn->connect_error;
} */
?>

<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Blog de Temas</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
</head>
<body>
    <!-- CABECERA -->
    <header id="cabecera">
        <!-- LOGO -->
        <div id="logo">
            <a href="/Blog_Deportes/index.php">
                Blog de Temas
            </a>
        </div>
        
        <!-- MENU -->
        <nav id="menu">
            <ul>
                <li>
                    <a href="/Blog_Deportes/index.php">Inicio</a>
                </li>
                <?php
                // Obtener categorías para el menú
                $categorias_menu = mysqli_query($conn, "SELECT * FROM categorias ORDER BY nombre ASC");
                if($categorias_menu && mysqli_num_rows($categorias_menu) > 0):
                    while($categoria = mysqli_fetch_assoc($categorias_menu)):
                ?>
                    <li>
                        <a href="/Blog_Deportes/index.php?categoria=<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></a>
                    </li>
                <?php 
                    endwhile;
                endif
                ?>
                <li>
                    <a href="/Blog_Deportes/sobre_mi.php">Sobre mí</a>
                </li>
                <li>
                    <a href="/Blog_Deportes/php/contacto.php">Contacto</a>
                </li>
            </ul>
        </nav>
        
        <div class="clearfix"></div>
    </header>
<!-- comentario -->