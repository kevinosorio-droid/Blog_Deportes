<?php
include 'conexion.php'; // Conectar a la BD

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
    $sql = "INSERT INTO usuarios (nombre, apellidos, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $apellidos, $email, $password);
    
    if ($stmt->execute()) {
        echo '<div class="alerta alerta-exito">Se registró correctamente</div>';
    } else {
        echo '<div class="alerta alerta-error">Error en algún dato</div>';
    }
    $stmt->close();
    $conn->close();
}
?>