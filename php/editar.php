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
$sql_select = "SELECT * FROM entradas WHERE id = ? AND usuario_id = ?";
$stmt_select = $conn->prepare($sql_select);
if ($stmt_select === false) {
    die("Error preparing select statement: " . $conn->error);
}
$stmt_select->bind_param("ii", $id, $usuario_id);
$stmt_select->execute();
$resultado = $stmt_select->get_result();
$entrada = $resultado->fetch_assoc();
$stmt_select->close();

if (!$entrada) {
    die("No tienes permiso para editar esta entrada.");
}

// Procesar la actualización si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? ''; // Assuming your database column is 'descripcion'

    $sql_update = "UPDATE entradas SET titulo = ?, descripcion = ? WHERE id = ? AND usuario_id = ?";
    $stmt_update = $conn->prepare($sql_update);

    if ($stmt_update === false) {
        die("Error preparing update statement: " . $conn->error);
    }

    $stmt_update->bind_param("ssii", $titulo, $descripcion, $id, $usuario_id);

    if ($stmt_update->execute()) {
        header("Location: entrada.php?id=$id&msg=Entrada actualizada");
        exit();
    } else {
        echo "Error al actualizar: " . $stmt_update->error;
    }
    $stmt_update->close();
}

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

        <label for="descripcion ">descripcion :</label>
        <textarea name="descripcion" rows="10" required><?php echo htmlspecialchars($entrada['descripcion']); ?></textarea>

        <input type="submit" value="Actualizar Entrada" class="boton boton-verde" />
        <a href="entrada.php?id=<?php echo $id; ?>" class="boton boton-rojo">Cancelar</a>
    </form>
</body>
</html>