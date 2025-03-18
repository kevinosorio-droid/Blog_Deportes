<?php
session_start();
include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);

    // Verificar si el correo ya existe
    $checkUser = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $checkUser->bind_param("s", $email);
    $checkUser->execute();
    $checkUser->store_result();

    if ($checkUser->num_rows > 0) {
        echo json_encode(["status" => "error", "mensaje" => "El correo ya está registrado."]);
        exit();
    }
    $checkUser->close();

    // Insertar el nuevo usuario
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellidos, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $apellidos, $email, $password);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "mensaje" => "Registro exitoso. Ahora puedes iniciar sesión."]);
    } else {
        echo json_encode(["status" => "error", "mensaje" => "Error al registrar el usuario."]);
    }

    $stmt->close();
    $conn->close();
}
?>