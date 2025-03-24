<?php
if (!isset($conn)) {
    include("php/conexion.php");  // Asegurar que la conexión existe
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
    <!-- CABECERA -->
    <header id="cabecera">
        <!-- LOGO -->
        <div id="logo">
            <a href="index.php">
                Blog de Temas
            </a>
        </div>
        
        <!-- MENU -->
        <nav id="menu">
            <ul>
                <li>
                    <a href="../index.php">Inicio</a>
                </li>
                <?php
                // Obtener categorías para el menú
                $categorias_menu = mysqli_query($conn, "SELECT * FROM categorias ORDER BY nombre ASC");
                if($categorias_menu && mysqli_num_rows($categorias_menu) > 0):
                    while($categoria = mysqli_fetch_assoc($categorias_menu)):
                ?>
                    <li>
                        <a href="index.php?categoria=<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></a>
                    </li>
                <?php 
                    endwhile;
                endif;
                ?>
                <li>
                    <a href="index.php">Sobre mí</a>
                </li>
                <li>
                    <a href="index.php">Contacto</a>
                </li>
            </ul>
        </nav>
        
        <div class="clearfix"></div>
    </header>