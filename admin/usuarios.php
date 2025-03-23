<?php
//session_start();
include __DIR__ . '/../config/test_conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'Administrador') {
    header("Location: ../public/account.php");
    exit;
}

// Configuración de paginación
$usuarios_por_pagina = 10; // Mostrar 10 usuarios por página
$pagina_actual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$offset = ($pagina_actual - 1) * $usuarios_por_pagina;

// Obtener el total de usuarios
$sql_total = "SELECT COUNT(*) AS total FROM usuarios";
$result_total = $conexion->query($sql_total);
$total_usuarios = $result_total->fetch_assoc()['total'];
$total_paginas = ceil($total_usuarios / $usuarios_por_pagina);

// Obtener la lista de usuarios con paginación
$sql = "SELECT id, nombre, email, rol FROM usuarios LIMIT $usuarios_por_pagina OFFSET $offset";
$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios - Anglican CelestiArte</title>
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
                <li><a href="../public/index.phpabout.html">Acerca de nosotros</a></li>
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

    <section class="user-list">
        <h2>Lista de Usuarios Registrados</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['rol']) ?></td>
                        <td>
                            <?php if ($row['email'] !== $_SESSION['usuario']['email']) { ?>
                                <a href="../admin/editar_usuario.php?id=<?= $row['id'] ?>" class="btn-edit">
                                    <i class="fas fa-pencil-alt"></i> <!-- Ícono de lápiz -->
                                </a>
                                <a href="../admin/eliminar_usuario.php?id=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                    Eliminar
                                </a>
                            <?php } else { ?>
                                <span class="btn-disabled">No puedes editarte</span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
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
