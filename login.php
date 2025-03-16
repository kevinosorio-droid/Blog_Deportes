<?php
session_start();
include("conexion.php");
$mensaje = ""; // Variable para almacenar mensajes de error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;

    if (!empty($usuario) && !empty($password)) {
        // Verifica que la conexión sea válida
        if (!$conn) {
            die("❌ Error de conexión: " . mysqli_connect_error());
        }

        // Habilita los errores de MySQL para depuración
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        // Prepara la consulta SQL
        $stmt = $conn->prepare("SELECT id, password FROM usuarios WHERE usuario = ?");
        
        if ($stmt) {
            $stmt->bind_param("s", $usuario);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows == 1) {
                $fila = $resultado->fetch_assoc();
                if (password_verify($password, $fila['password'])) {
                    $_SESSION['usuario'] = $usuario;
                    exit();
                } else {
                    $mensaje = "❌ Contraseña incorrecta.";
                }
            } else {
                $mensaje = "❌ Usuario no encontrado.";
            }
            $stmt->close();
        } else {
            $mensaje = "❌ Error en la consulta SQL: " . $conn->error;
        }
    } else {
        $mensaje = "❌ Debes completar todos los campos.";
    }
}
?>

<form method="post">
    <input type="text" name="usuario" placeholder="Usuario" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit">Iniciar Sesión</button>
</form>

<?php
if (!empty($mensaje)) {
    echo "<p class='error'>$mensaje</p>";
}
?>
