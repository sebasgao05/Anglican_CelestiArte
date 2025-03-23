<?php
session_start();
include __DIR__ . '/../config/test_conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['usuario'] = [
                "nombre" => $user['nombre'],
                "email" => $user['email'],
                "rol" => $user['rol']
            ];
            header("Location: account.php");
            exit;
        } else {
            die("Error: Contraseña incorrecta.");
        }
    } else {
        die("Error: Usuario no encontrado.");
    }

    $stmt->close();
    $conexion->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Anglican CelestiArte</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">
            <a href="index.php"><img src="img/acc-logo.png" alt="Anglican CelestiArte"></a>
            <a href="index.php"><h1>Anglican CelestiArte</h1></a>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="about.html">Acerca de nosotros</a></li>
                <?php if ($_SESSION['usuario']['rol'] === 'Administrador') { ?>
                    <li><a href="../admin/usuarios.php">Gestionar Usuarios</a></li>
                <?php } ?>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <section class="profile-container">
        <h2>Bienvenido, <?= $_SESSION['usuario']['nombre'] ?></h2>
        <p><strong>Correo:</strong> <?= $_SESSION['usuario']['email'] ?></p>
        <p><strong>Rol:</strong> <?= $_SESSION['usuario']['rol'] ?></p>
    </section>

</body>
</html>
