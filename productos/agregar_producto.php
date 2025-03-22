<?php
session_start();
include '../config/conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'Administrador') {
    header("Location: ../account.php"); // Redirigir si no es administrador
    exit;
}

// Procesar el formulario de agregar producto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];

    // Validar imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $imagen_tipo = $_FILES['imagen']['type'];
        
        // Directorio donde se guardarán las imágenes
        $directorio_imagenes = '../assets/img/';

        // Extensiones permitidas
        $extensiones_permitidas = ['image/jpeg', 'image/png', 'image/jpg'];
        
        // Verificar si la extensión de la imagen es permitida
        if (in_array($imagen_tipo, $extensiones_permitidas)) {
            $imagen_destino = $directorio_imagenes . basename($imagen_nombre);
            
            // Mover la imagen del directorio temporal al directorio final
            if (move_uploaded_file($imagen_tmp, $imagen_destino)) {
                // Guardar en la base de datos
                $sql = "INSERT INTO productos (nombre, precio, descripcion, imagen) VALUES (?, ?, ?, ?)";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("sdss", $nombre, $precio, $descripcion, $imagen_destino);

                if ($stmt->execute()) {
                    header("Location: productos.php"); // Redirigir a la lista de productos
                    exit;
                } else {
                    echo "Error al agregar el producto.";
                }
            } else {
                echo "Error al subir la imagen.";
            }
        } else {
            echo "El tipo de imagen no es permitido.";
        }
    } else {
        echo "No se ha seleccionado ninguna imagen.";
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
        <a href="../index.php"><img src="../assets/img/acc-logo.png" alt="Anglican CelestiArte"></a>
        <a href="../index.php"><h1>Anglican CelestiArte</h1></a>
    </div>
    <nav>
        <ul>
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="../about.html">Acerca de nosotros</a></li>
            <li><a href="account.php">Mi Cuenta</a></li>
            <li><a href="productos.php">Productos</a></li>
        </ul>
    </nav>
</header>

<section class="edit-user-container">
    <h2>Agregar Nuevo Producto</h2>

    <form action="agregar_producto.php" method="POST" enctype="multipart/form-data">
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
                <td><label for="imagen">Imagen del Producto:</label></td>
                <td><input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png, image/jpg" required></td>
            </tr>
            <tr>
                <td colspan="2" class="center">
                    <button type="submit" class="btn-save">Agregar Producto</button>
                </td>
            </tr>
        </table>
    </form>
</section>

</body>
</html>
