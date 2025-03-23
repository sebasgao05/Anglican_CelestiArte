<?php
//session_start();
include '../config/test_conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'Administrador') {
    header("Location: ../account.php"); // Redirigir si no es administrador
    exit;
}

// Verificar si se pasó un ID de producto por GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos del producto que se va a editar
    $sql = "SELECT * FROM productos WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si el producto existe
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc(); // Asignar los datos del producto a la variable $product
    } else {
        die("Error: Producto no encontrado.");
    }
} else {
    die("Error: No se especificó el ID del producto.");
}

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_POST['imagen']; // Imagen URL

    // Actualizar los datos del producto en la base de datos
    $sql_update = "UPDATE productos SET nombre = ?, precio = ?, descripcion = ?, imagen = ? WHERE id = ?";
    $stmt_update = $conexion->prepare($sql_update);
    $stmt_update->bind_param("sdssi", $nombre, $precio, $descripcion, $imagen, $id);

    if ($stmt_update->execute()) {
        header("Location: productos.php"); // Redirigir a la lista de productos
        exit;
    } else {
        echo "Error al actualizar el producto.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">
            <a href="index.php"><img src="../assets/img/acc-logo.png" alt="Anglican CelestiArte"></a>
            <a href="index.php"><h1>Anglican CelestiArte</h1></a>
        </div>
        <nav>
            <ul>
                <li><a href="../public/index.php">Inicio</a></li>
                <li><a href="../public/hpabout.html">Acerca de nosotros</a></li>
                <li><a href="../public/account.php">Mi Cuenta</a></li>
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
    <h2>Editar Producto</h2>
    <form action="editar_producto.php?id=<?= $product['id'] ?>" method="POST">
        <table class="edit-user-table">
            <tr>
                <td><label for="nombre">Nombre del Producto:</label></td>
                <td><input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($product['nombre']) ?>" required></td>
            </tr>
            <tr>
                <td><label for="precio">Precio:</label></td>
                <td><input type="number" id="precio" name="precio" value="<?= htmlspecialchars($product['precio']) ?>" step="0.01" required></td>
            </tr>
            <tr>
                <td><label for="descripcion">Descripción:</label></td>
                <td><textarea id="descripcion" name="descripcion" required><?= htmlspecialchars($product['descripcion']) ?></textarea></td>
            </tr>
            <tr>
                <td><label for="imagen">Imagen (URL):</label></td>
                <td><input type="text" id="imagen" name="imagen" value="<?= htmlspecialchars($product['imagen']) ?>" required></td>
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
