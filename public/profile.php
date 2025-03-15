<?php
session_start();
include __DIR__ . '/../config/test_conexion.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: account.php");
    exit;
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
            <a href="index.html"><img src="img/acc-logo.png" alt="Anglican CelestiArte"></a>
            <a href="index.html"><h1>Anglican CelestiArte</h1></a>
        </div>
        <nav>
            <ul>
                <li><a href="index.html">Inicio</a></li>
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
