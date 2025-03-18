<?php
session_start();
include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "SELECT id, nombre, email, password FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();
        if (password_verify($password, $usuario['password'])) {
            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'nombre' => $usuario['nombre'],
                'email' => $usuario['email']
            ];
            echo json_encode(["status" => "success", "mensaje" => "Inicio de sesión exitoso."]);
        } else {
            echo json_encode(["status" => "error", "mensaje" => "Contraseña incorrecta."]);
        }
    } else {
        echo json_encode(["status" => "error", "mensaje" => "El usuario no existe."]);
    }

    $stmt->close();
    $conn->close();
}
?>