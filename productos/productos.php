<?php
//session_start();
include '../config/test_conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'Administrador') {
    header("Location: ../account.php"); // Redirigir si no es administrador
    exit;
}

// Configuración de paginación
$productos_por_pagina = 10; // Mostrar 10 productos por página
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_actual - 1) * $productos_por_pagina;

// Obtener los productos de la base de datos
$sql = "SELECT * FROM productos LIMIT $productos_por_pagina OFFSET $offset";
$result = $conexion->query($sql);

// Obtener el número total de productos
$sql_total = "SELECT COUNT(*) FROM productos";
$result_total = $conexion->query($sql_total);
$total_productos = $result_total->fetch_row()[0];
$total_paginas = ceil($total_productos / $productos_por_pagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>
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
                <li><a href="../public/about.html">Acerca de nosotros</a></li>
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

    <section class="products-container">
        <h2>Gestión de Productos</h2>
        
        <!-- Botón para agregar un nuevo producto -->
        <a href="agregar_producto.php" class="btn-save">Agregar Nuevo Producto</a>

        <!-- Tabla de productos -->
        <table class="products-table" >
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = $result->fetch_assoc()): ?>
                    <tr>
                        <td><img src="<?= htmlspecialchars($product['imagen']) ?>" alt="Imagen del producto" width="100" height="100"></td>
                        <td><?= htmlspecialchars($product['nombre']) ?></td>
                        <td><?= number_format($product['precio'], 2) ?> $</td>
                        <td><?= htmlspecialchars($product['descripcion']) ?></td>
                        <td>
                            <a href="editar_producto.php?id=<?= $product['id'] ?>" class="btn-edit">
                                <i class="fas fa-pencil-alt"></i> <!-- Ícono de lápiz -->
                            </a>
                            <a href="eliminar_producto.php?id=<?= $product['id'] ?>" class="btn-delete" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="pagination">
            <?php if ($pagina_actual > 1): ?>
                <a href="?pagina=<?= $pagina_actual - 1 ?>" class="page-link">«</a>
            <?php endif; ?>

            <?php for ($i = max(1, $pagina_actual - 2); $i <= min($total_paginas, $pagina_actual + 2); $i++): ?>
                <a href="?pagina=<?= $i ?>" class="page-link <?= ($i == $pagina_actual) ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($pagina_actual < $total_paginas): ?>
                <a href="?pagina=<?= $pagina_actual + 1 ?>" class="page-link">»</a>
            <?php endif; ?>
        </div>
    </section>

</body>
</html>
