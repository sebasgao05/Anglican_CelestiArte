<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'test_conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $rol = isset($_POST['isAdmin']) ? 'Administrador' : 'Usuario';

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($email) || empty($password)) {
        die("Error: Todos los campos son obligatorios.");
    }

    // Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Error: Correo electrónico no válido.");
    }

    // Hashear la contraseña antes de insertarla en la base de datos
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Insertar usuario en la base de datos
    $sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    $stmt->bind_param("ssss", $nombre, $email, $password_hashed, $rol);

    if ($stmt->execute()) {
        $_SESSION['usuario'] = [
            "nombre" => $nombre,
            "email" => $email,
            "rol" => $rol
        ];
        header("Location: account.php");
        exit;
    } else {
        die("Error al insertar usuario: " . $stmt->error);
    }
    $stmt->close();
    $conexion->close();
}
?>
