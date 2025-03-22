<?php
require_once 'conexion.php';
if(!isset($_SESSION)){
    session_start();
}


if(isset($_POST['nombre'])){
    // Recoger el nombre de la categoría
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    
    // Comprobar si la categoría ya existe
    $sql_check = "SELECT * FROM categorias WHERE nombre = '$nombre'";
    $check = mysqli_query($conn, $sql_check);
    
    if(mysqli_num_rows($check) > 0){
        $_SESSION['error_categoria'] = "La categoría '$nombre' ya existe";
    } else {
        // Insertar la categoría
        $sql = "INSERT INTO categorias VALUES(null, '$nombre');";
        $guardar = mysqli_query($conn, $sql);
        
        if($guardar){
            $_SESSION['completado'] = "La categoría se ha guardado correctamente";
        } else {
            $_SESSION['error_categoria'] = "Error al guardar la categoría: " . mysqli_error($conn);
        }
    }
    
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Categorías</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Crear nueva categoría</h2>
        
        <?php if(isset($_SESSION['completado'])): ?>
            <div class="alerta alerta-exito">
                <?=$_SESSION['completado']?>
            </div>
        <?php elseif(isset($_SESSION['error_categoria'])): ?>
            <div class="alerta alerta-error">
                <?=$_SESSION['error_categoria']?>
            </div>
        <?php endif; ?>
        
        <?php
        // Borrar sesiones
        unset($_SESSION['error_categoria']);
        unset($_SESSION['completado']);
        ?>
        
        <form action="crear-categorias.php" method="POST">
            <label for="nombre">Nombre de la categoría:</label>
            <input type="text" name="nombre" id="nombre" required/>
            
            <input type="submit" value="Guardar" class="btn btn-primary"/>
        </form>
        <button class="btn btn-volver">
            <a href="../index.php">Volver al inicio</a>
        </button>
    </div>
</body>
</html> 