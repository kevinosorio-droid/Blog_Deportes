<?php
session_start();
include("conexion.php");

$mensaje = ""; // Variable para mostrar mensajes

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $fila = $resultado->fetch_assoc();
        if (password_verify($password, $fila['password'])) {
            $_SESSION['usuario'] = $usuario;
            header("Location: index.php"); // Redirigir a la página principal
            exit();
        } else {
            $mensaje = "❌ Contraseña incorrecta.";
        }
    } else {
        $mensaje = "❌ Usuario no encontrado.";
    }
}

// Si ya hay sesión iniciada, ocultamos los formularios
if (isset($_SESSION['usuario'])) {
    echo "<p class='success'>✅ ¡Bienvenido, " . $_SESSION['usuario'] . "!</p>";
    echo "<a href='logout.php'>Cerrar sesión</a>";
} else {
?>
    <form method="post">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Iniciar Sesión</button>
    </form>
<?php
}
if ($mensaje) {
    echo "<p class='error'>$mensaje</p>";
}
?>
