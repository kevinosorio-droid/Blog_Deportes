<?php
// Habilitar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("../php/conexion.php");

// Verificar que el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

$usuario_id = $_SESSION['usuario']['id'];
$id = $_GET['id'] ?? 0;

// Obtener la entrada actual
$sql = "SELECT * FROM entradas WHERE id = ? AND usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
$entrada = $resultado->fetch_assoc();

if (!$entrada) {
    die("No tienes permiso para editar esta entrada.");
}

// Procesar la actualización si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $contenido = $_POST['contenido'] ?? '';
    
    $sql = "UPDATE entradas SET titulo = ?, contenido = ? WHERE id = ? AND usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $titulo, $contenido, $id, $usuario_id);

    if ($stmt->execute()) {
        header("Location: entrada.php?id=$id&msg=Entrada actualizada");
        exit();
    } else {
        echo "Error al actualizar.";
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Entrada</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Editar Entrada</h1>
    
    <form action="" method="POST">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" value="<?php echo htmlspecialchars($entrada['titulo']); ?>" required />

        <label for="contenido">Contenido:</label>
        <textarea name="contenido" rows="10" required><?php echo htmlspecialchars($entrada['contenido']); ?></textarea>

        <input type="submit" value="Actualizar Entrada" class="boton boton-verde" />
        <a href="entrada.php?id=<?php echo $id; ?>" class="boton boton-rojo">Cancelar</a>
    </form>
</body>
</html>
