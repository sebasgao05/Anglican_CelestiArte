<?php
//session_start();
include '../config/test_conexion.php';

// Obtener los productos de la base de datos
$sql = "SELECT * FROM productos";
$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anglican CelestiArte</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Barra de navegación -->
    <header class="navbar">
        <div class="logo">
            <a href="index.php"><img src="../assets/img/acc-logo.png" alt="Anglican CelestiArte"></a>
            <a href="index.php"><h1>Anglican CelestiArte</h1></a>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="about.html">Acerca de nosotros</a></li>
                <?php if (isset($_SESSION['usuario'])): ?>
                    <li><a href="account.php">Mi Cuenta</a></li>
                <?php else: ?>
                    <li><a href="login.php">Iniciar Sesión</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <!-- Sección principal -->
    <section class="hero">
        <h2>Su fuente para el Libro de Oración Común (LOC) de 1928... ¡y más!</h2>
        <p class="notice">
            Pagina de Prueba para Tienda en Linea
        </p>
    </section>


    <section class="products">
        <h2>Productos Disponibles</h2>

            <?php while ($product = $result->fetch_assoc()): ?>
                <div class="product-list">
                    <div s">
                        <img class="prodcut-image" src="<?= htmlspecialchars($product['imagen']) ?>" alt="Imagen del <?= htmlspecialchars($product['nombre']) ?>">
                        <h4><?= htmlspecialchars($product['nombre']) ?></h3>
                        <p class="price">$ <?= number_format($product['precio'], 2) ?> COP</p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
    
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-info">
                <h3>The Anglican Catholic Church</h3>
                <p>
                    La Iglesia Católica Anglicana es un cuerpo mundial de creyentes,con iglesias en Estados Unidos,
                    Canadá, Gran Bretaña, Australia, África, India y América del Sur.
                </p>
                <p>© 2025 The Anglican Catholic Church & Anglican CelestiArte.</p>
            </div>
    
            <div class="footer-contact">
                <h3>Office of the Anglican CelestiArte</h3>
                <p>📍 Bogota, D.C., Colombia</p>
                <p>📧 <a href="mailto:sebasgao05@icloud.com">sebasgao05@icloud.com</a></p>
                <p>📞 Call Us Today: (+57) 3246007203</p>
            </div>
        </div>
    
        <a href="#" class="scroll-to-top">
            <i class="fas fa-arrow-up"></i>
        </a>
    </footer>
    
    <!-- Agregar FontAwesome para los iconos -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    
</body>
</html>