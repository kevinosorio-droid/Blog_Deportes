<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    $sql = "SELECT id, password FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        
        if (password_verify($password, $hashed_password)) {
            session_start();
            $_SESSION['user_id'] = $id;
            header("Location: pagina_oficial.php");
            exit();
        } else {
            echo '<div class="alerta alerta-error">Contraseña incorrecta</div>';
        }
    } else {
        echo '<div class="alerta alerta-error">Usuario no existe</div>';
    }
    $stmt->close();
    $conn->close();
}
?>
