<?php
require_once __DIR__ . '/../../controllers/CarritoController.php';
$keepnav = isset($_GET['keepnav']) && $_GET['keepnav'] == '1';
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <script>
        // expose login state to client-side JS to avoid unauthenticated AJAX actions
        window.isLoggedIn = <?= !empty($_SESSION['user']) ? 'true' : 'false' ?>;
        window.keepnav = <?= $keepnav ? 'true' : 'false' ?>;
    </script>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="index.php"> TiendaOnline</a>
            </div>
            <ul class="nav-links">
                <li><a href="index.php?url=inicio/index">Inicio</a></li>
                <li><a href="index.php?url=nosotros/index&keepnav=1">Nosotros</a></li>
                <li><a href="index.php?url=carrito/index&keepnav=1">Carrito</a> 

            <?php
             
             $carritoController = new CarritoController();
              $contador= $carritoController->count();
            echo "($contador)";
            ?>
            
            
            
            
            </li>
                <?php if (!empty($_SESSION['user'])): ?>
                    <li><a href="index.php?url=usuarios/perfil&keepnav=1">Hola, <?= htmlspecialchars($_SESSION['user']['username']) ?></a></li>
                    <li><a href="index.php?url=usuarios/logout&keepnav=1">Cerrar sesión</a></li>
                <?php else: ?>
                    <li><a href="index.php?url=usuarios/login&keepnav=1">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main class="contenido">
        <?php if (! $keepnav): ?>
        <section class="hero">
             <img src="images/foto2.png" alt="Imagen principal de la tienda" class="hero-imagen">
            <div class="hero-texto">
                <h1>Bienvenido a TiendaOnline</h1>
                <p>Encuentra los mejores productos al mejor precio </p>
            </div>
        </section>
        <?php endif; ?>
    </main>
    
</body>
</html>
