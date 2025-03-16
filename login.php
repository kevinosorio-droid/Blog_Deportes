<?php
session_start();
include("conexion.php"); // Asegúrate de que este archivo tiene la conexión a la DB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;

    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, nombre, apellidos, email, password FROM usuarios WHERE email = ?");
        if ($stmt) {
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
                    echo json_encode(["status" => "success"]);
                    exit();
                } else {
                    echo json_encode(["status" => "error", "mensaje" => "Contraseña incorrecta."]);
                    exit();
                }
            } else {
                echo json_encode(["status" => "error", "mensaje" => "El usuario no existe."]);
                exit();
            }
        } else {
            echo json_encode(["status" => "error", "mensaje" => "Error en la consulta SQL."]);
            exit();
        }
    } else {
        echo json_encode(["status" => "error", "mensaje" => "Todos los campos son obligatorios."]);
        exit();
    }
}

?>
