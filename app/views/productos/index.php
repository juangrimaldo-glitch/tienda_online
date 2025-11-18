<?php // $productos y $categorias son provistos por el controlador ?>

<div class="container py-4 text-light">

    <!-- Título -->
    <h2 class="text-center display-5 fw-bold mb-4" style="color: #f5d06f; text-shadow: 0 0 6px black;">
        Nuestros Productos
    </h2>

    <!-- 🔹 Filtro por categoría -->
    <form method="get" action="index.php" class="mb-4 d-flex align-items-center gap-3 bg-dark p-3 rounded shadow">
        <input type="hidden" name="url" value="producto/index">

        <label for="categoria" class="fw-semibold" style="color:#f5d06f;">Filtrar por categoría:</label>

        <select name="categoria" id="categoria" class="form-select bg-dark text-light border-warning"
                style="max-width: 250px; cursor:pointer;" onchange="this.form.submit()">
            <option value="">Todas</option>
            <?php foreach ($categorias as $c): ?>
                <option value="<?= $c['id'] ?>"
                    <?= (isset($_GET['categoria']) && $_GET['categoria'] == $c['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>


    <!-- 🔹 Grid de productos -->
    <div class="row g-4">
        <?php foreach ($productos as $p): ?>
            <?php 
                $rutaImagen = $p['imagen'];
                if (!preg_match('/^images\//', $rutaImagen)) {
                    $rutaImagen = 'images/' . $rutaImagen;
                }
            ?>
            
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="card bg-dark text-center border border-warning shadow producto-card-hover">

                    <a href="index.php?url=producto/detalle/<?= $p['id'] ?>&keepnav=1">
                        <img src="<?= htmlspecialchars($rutaImagen) ?>" 
                             alt="<?= htmlspecialchars($p['nombre']) ?>" 
                             class="card-img-top rounded-top producto-img"
                             onerror="this.style.border='2px solid red'; this.alt='Imagen no encontrada';">
                    </a>

                    <div class="card-body p-2">
                        <h5 class="card-title text-truncate" style="color:#f5d06f;">
                            <?= htmlspecialchars($p['nombre']) ?>
                        </h5>
                        <p class="fw-bold text-light">$<?= $p['precio'] ?></p>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<style>
    body {
        background: #181616ff !important;  /* Fondo oscuro elegante */
    }

    .producto-img {
        height: 130px;
        object-fit: cover;
        transition: transform .25s ease-in-out;
    }

    .producto-card-hover:hover .producto-img {
        transform: scale(1.07);
        filter: brightness(1.2);
    }

    .producto-card-hover {
        transition: .25s ease-in-out;
    }

    .producto-card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 0 15px 2px rgba(255, 215, 0, 0.4);
    }
</style>
