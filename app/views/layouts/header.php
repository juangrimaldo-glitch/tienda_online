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
    <title>Tienda Online - Premium</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Estilos embebidos -->
    <style>
        /* Navbar estilo premium */
        .navbar {
            background: rgba(0, 0, 0, 0.75) !important;
            backdrop-filter: blur(6px);
        }
        .navbar-brand, .nav-link {
            color: #f5d06f !important;
            font-weight: 500;
        }
        .nav-link:hover {
            color: white !important;
        }

        /* Estilos del hero */
        .hero-img {
            width: 100%;
            height: 420px;
            object-fit: cover;
            filter: brightness(0.55);
        }

        .hero-text {
            position: absolute;
            top: 50%;
            right: 5%;
            transform: translateY(-50%);
            max-width: 40%;
            animation: fadeInRight 1.2s;
        }

        .hero-title {
            font-size: 2.5rem;
            color: #f8e79b;
            font-weight: 800;
            text-shadow: 0 0 10px black;
            letter-spacing: 2px;
        }

        .hero-sub {
            font-size: 1.2rem;
            color: #ffffff;
            background: rgba(0, 0, 0, 0.45);
            padding: 8px 14px;
            border-radius: 6px;
            backdrop-filter: blur(3px);
        }

        @media (max-width: 768px) {
            .hero-text { max-width: 90%; right: 50%; transform: translate(50%, -50%); text-align: center; }
            .hero-title { font-size: 2rem; }
        }
    </style>
</head>
<body>

<script>
    window.isLoggedIn = <?= !empty($_SESSION['user']) ? 'true' : 'false' ?>;
    window.keepnav = <?= $keepnav ? 'true' : 'false' ?>;
</script>

<header>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold animate__animated animate__fadeInDown" href="index.php">TiendaOnline</a>
            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse animate__animated animate__fadeInRight" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item"><a class="nav-link" href="index.php?url=inicio/index">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?url=nosotros/index&keepnav=1">Nosotros</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?url=Contacto/index&keepnav=1">Contacto</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?url=Direccion/index&keepnav=1">Dirección</a></li>

                    <li class="nav-item">
                        <a class="nav-link" href="index.php?url=carrito/index&keepnav=1">
                            Carrito 
                            <?php
                            $carritoController = new CarritoController();
                            $contador = $carritoController->count();
                            echo " ($contador)";
                            ?>
                        </a>
                    </li>

                    <?php if (!empty($_SESSION['user'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?url=usuarios/perfil&keepnav=1">
                                Hola, <?= htmlspecialchars($_SESSION['user']['username']) ?> 
                                (<?= htmlspecialchars($_SESSION['user']['rol_nombre']) ?>)
                            </a>
                        </li>

                        <?php if ($_SESSION['user']['rol_nombre'] === 'admin'): ?>
                            <li class="nav-item"><a class="nav-link" href="index.php?url=admin/productos&keepnav=1">Panel Admin</a></li>
                        <?php endif; ?>

                        <li class="nav-item"><a class="nav-link" href="index.php?url=usuarios/logout&keepnav=1">Cerrar sesión</a></li>

                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="index.php?url=usuarios/login&keepnav=1">Login</a></li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="contenido">
<?php if (!$keepnav): ?>
<section class="hero position-relative">
    <img src="images/foto2.jpg" class="hero-img animate__animated animate__fadeIn">

    <div class="hero-text animate__animated animate__fadeInRight">
        <h1 class="hero-title animate__animated animate__zoomIn">
            Bienvenido a <span style="color:white;">TiendaOnline</span>
        </h1>
        <p class="hero-sub animate__animated animate__fadeInUp">
            Compra fácil, rápido y con el mejor estilo.
        </p>
    </div>
</section>
<?php endif; ?>
</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
