<?php
//session_start();
include __DIR__ . '/../config/test_conexion.php';

// Verificar si el usuario es Administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'Administrador') {
    header("Location: ../public/account.php");
    exit;
}

// Verificar si se recibió un ID válido
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT id, nombre, email, rol FROM usuarios WHERE id = ?";
    $stmt = $conexion->prepare($sql); 
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        die("Error: Usuario no encontrado.");
    }
}

// Si se envió el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $rol = $_POST['rol'];

    $sql_update = "UPDATE usuarios SET nombre = ?, email = ?, rol = ? WHERE id = ?";
    $stmt_update = $conexion->prepare($sql_update);
    $stmt_update->bind_param("sssi", $nombre, $email, $rol, $id);

    if ($stmt_update->execute()) {
        header("Location: usuarios.php");
        exit;
    } else {
        die("Error al actualizar usuario: " . $stmt_update->error);
    }

    $stmt_update->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios - Anglican CelestiArte</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="style_editar.css">
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
                <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] == 'Administrador') : ?>
                    <li><a href="../productos/productos.php">Productos</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <section class="edit-user-container">
        <h2>Editar Usuario</h2>
        <form action="editar_usuario.php?id=<?= $user['id'] ?>" method="POST">
            <table class="edit-user-table">
                <tr>
                    <td><label for="nombre">Nombre:</label></td>
                    <td><input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($user['nombre']) ?>" required></td>
                </tr>
                <tr>
                    <td><label for="email">Correo:</label></td>
                    <td><input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required></td>
                </tr>
                <tr>
                    <td><label for="rol">Rol:</label></td>
                    <td>
                        <select id="rol" name="rol">
                            <option value="Usuario" <?= $user['rol'] === 'Usuario' ? 'selected' : '' ?>>Usuario</option>
                            <option value="Administrador" <?= $user['rol'] === 'Administrador' ? 'selected' : '' ?>>Administrador</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="center">
                        <button type="submit" class="btn-save">Guardar Cambios</button>
                    </td>
                </tr>
            </table>
        </form>
    </section>
</body>
</html>
