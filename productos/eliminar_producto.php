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

    // Verificar si el producto existe
    $sql_check = "SELECT * FROM productos WHERE id = ?";
    $stmt_check = $conexion->prepare($sql_check);
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // El producto existe, proceder a eliminar
        $sql_delete = "DELETE FROM productos WHERE id = ?";
        $stmt_delete = $conexion->prepare($sql_delete);
        $stmt_delete->bind_param("i", $id);

        if ($stmt_delete->execute()) {
            header("Location: productos.php"); // Redirigir a la lista de productos
            exit;
        } else {
            echo "Error al eliminar el producto.";
        }
    } else {
        die("Error: Producto no encontrado.");
    }
} else {
    die("Error: No se especificó el ID del producto.");
}
?>
