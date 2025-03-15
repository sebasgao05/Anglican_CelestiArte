<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Cuenta - Anglican CelestiArte</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body>

<header class="navbar">
    <div class="logo">
        <a href="index.html"><img src="../assets/img/acc-logo.png" alt="Anglican CelestiArte"></a>
        <a href="index.html"><h1>Anglican CelestiArte</h1></a>
    </div>
    <nav>
        <ul>
            <li><a href="index.html">Inicio</a></li>
            <li><a href="about.html">Acerca de nosotros</a></li>
            <li><a href="account.php">Mi Cuenta</a></li>
            <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'Administrador') { ?>
                <li><a href="../admin/usuarios.php">Gestionar Usuarios</a></li>
            <?php } ?>
        </ul>
    </nav>
</header>

<section class="account-container">
    <?php if (isset($_SESSION['usuario'])) { ?>
        <!-- Si el usuario ha iniciado sesión, mostrar su información -->
        <div class="form-container">
            <h2>Bienvenido, <?= $_SESSION['usuario']['nombre'] ?></h2>
            <p><strong>Correo:</strong> <?= $_SESSION['usuario']['email'] ?></p>
            <p><strong>Rol:</strong> <?= $_SESSION['usuario']['rol'] ?></p>
            <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
        </div>
    <?php } else { ?>
        <!-- Si el usuario no ha iniciado sesión, mostrar los formularios -->
        <div class="form-container">
            <h2>Iniciar Sesión</h2>
            <form action="login.php" method="POST">
                <input type="email" name="email" placeholder="Correo Electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <button type="submit">Ingresar</button>
            </form>
        </div>

        <div class="form-container">
            <h2>Crear Cuenta</h2>
            <form action="register.php" method="POST">
                <input type="text" name="nombre" placeholder="Nombre Completo" required>
                <input type="email" name="email" placeholder="Correo Electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <label>
                    <input type="checkbox" name="isAdmin"> Registrarse como Administrador
                </label>
                <button type="submit">Registrarse</button>
            </form>
        </div>
    <?php } ?>
</section>

</body>
</html>
