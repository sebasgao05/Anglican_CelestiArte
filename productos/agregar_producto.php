<?php
//session_start();
include '../config/test_conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'Administrador') {
    header("Location: ../account.php"); // Redirigir si no es administrador
    exit;
}

// Procesar el formulario para agregar el producto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_POST['imagen']; // La imagen se puede agregar como un enlace (URL)

    // Validación básica (puedes agregar más validaciones)
    if (!empty($nombre) && !empty($precio) && !empty($descripcion) && !empty($imagen)) {
        // Insertar el nuevo producto en la base de datos
        $sql = "INSERT INTO productos (nombre, precio, descripcion, imagen) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sdss", $nombre, $precio, $descripcion, $imagen);

        if ($stmt->execute()) {
            header("Location: productos.php"); // Redirigir a la lista de productos
            exit;
        } else {
            echo "Error al agregar el producto.";
        }
    } else {
        echo "Por favor, complete todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
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
        <h2>Agregar Producto</h2>

        <form action="agregar_producto.php" method="POST">
            <table class="edit-user-table">
                <tr>
                    <td><label for="nombre">Nombre del Producto:</label></td>
                    <td><input type="text" id="nombre" name="nombre" required></td>
                </tr>
                <tr>
                    <td><label for="precio">Precio:</label></td>
                    <td><input type="number" id="precio" name="precio" step="0.01" required></td>
                </tr>
                <tr>
                    <td><label for="descripcion">Descripción:</label></td>
                    <td><textarea id="descripcion" name="descripcion" required></textarea></td>
                </tr>
                <tr>
                    <td><label for="imagen">Imagen (URL):</label></td>
                    <td><input type="text" id="imagen" name="imagen" required></td>
                </tr>
                <tr>
                    <td colspan="2" class="center">
                        <button type="submit" class="btn-save">Guardar Producto</button>
                    </td>
                </tr>
            </table>
        </form>
    </section>

</body>
</html>
