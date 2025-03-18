<?php
session_start();
include("conexion.php");

$response = ["status" => "error", "mensaje" => "Ocurrió un error inesperado."];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        // Iniciar sesión
        if ($action == "login") {
            $email = trim($_POST['email'] ?? "");
            $password = trim($_POST['password'] ?? "");

            if (!empty($email) && !empty($password)) {
                $stmt = $conn->prepare("SELECT id, nombre, apellidos, email, password FROM usuarios WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $resultado = $stmt->get_result();

                if ($resultado->num_rows == 1) {
                    $usuario = $resultado->fetch_assoc();
                    if (password_verify($password, $usuario['password'])) {
                        $_SESSION['usuario'] = [
                            'id' => $usuario['id'],
                            'nombre' => $usuario['nombre'],
                            'apellidos' => $usuario['apellidos'],
                            'email' => $usuario['email']
                        ];
                        $response = ["status" => "success", "mensaje" => "Inicio de sesión exitoso."];
                    } else {
                        $response["mensaje"] = "Contraseña incorrecta.";
                    }
                } else {
                    $response["mensaje"] = "El usuario no existe.";
                }
            } else {
                $response["mensaje"] = "Todos los campos son obligatorios.";
            }
        }

        // Registro de usuario
        if ($action == "register") {
            $nombre = trim($_POST['nombre'] ?? "");
            $apellidos = trim($_POST['apellidos'] ?? "");
            $email = trim($_POST['email'] ?? "");
            $password = trim($_POST['password'] ?? "");
            
            if (!empty($nombre) && !empty($apellidos) && !empty($email) && !empty($password)) {
                $password_hashed = password_hash($password, PASSWORD_BCRYPT);

                $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellidos, email, password, fecha) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $nombre, $apellidos, $email, $password_hashed, $fecha);

                if ($stmt->execute()) {
                    $response = ["status" => "success", "mensaje" => "Registro exitoso. Ahora puedes iniciar sesión."];
                } else {
                    $response["mensaje"] = "Error al registrar el usuario. Es posible que el correo ya esté registrado.";
                }
            } else {
                $response["mensaje"] = "Todos los campos son obligatorios.";
            }
        }
    }
}

// Cerrar sesión
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

echo json_encode($response);
exit();
?>
