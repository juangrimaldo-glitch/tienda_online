<?php // $producto es pasado por el controlador ?>
<?php 
require_once __DIR__ . '/../../models/Inventario.php';
$cantidad = Inventario::getCantidad($producto['id']);
$keep = isset($_GET['keepnav']) && $_GET['keepnav']=='1' ? '&keepnav=1' : '';
?>

<div class="container py-5 text-light">
    <div class="row detalle-producto g-4 align-items-start">

        <!-- ==================== IZQUIERDA ==================== -->
        <div class="col-md-6 d-flex flex-column">

            <!-- Imagen -->
            <div class="text-center mb-4">
                <img 
                    src="<?= htmlspecialchars($producto['imagen'] ?? 'assets/img/no-image.png') ?>" 
                    alt="<?= htmlspecialchars($producto['nombre']) ?>" 
                    class="img-fluid rounded shadow-lg producto-img"
                    onerror="this.src='assets/img/no-image.png'; this.style.border='2px solid red';"
                >
            </div>

            <!-- Formulario de Reseña -->
            <div class="bg-dark p-4 rounded shadow-lg flex-grow-1">
                <h3 class="fw-bold mb-3" style="color:#f5d06f;">Deja tu reseña</h3>

                <form action="index.php?url=resena/crear" method="post" class="form-resena">
                    <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Tu nombre:</label>
                        <input type="text" name="usuario" class="form-control bg-dark text-light border-warning" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Calificación:</label>
                        <select name="calificacion" class="form-select bg-dark text-light border-warning estrellas" required>
                            <option value="5">★★★★★</option>
                            <option value="4">★★★★☆</option>
                            <option value="3">★★★☆☆</option>
                            <option value="2">★★☆☆☆</option>
                            <option value="1">★☆☆☆☆</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Comentario:</label>
                        <textarea name="comentario" rows="3" class="form-control bg-dark text-light border-warning" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-warning fw-bold">Enviar reseña</button>
                </form>
            </div>
        </div>

        <!-- ==================== DERECHA ==================== -->
        <div class="col-md-6 d-flex flex-column">

            <!-- Información del producto -->
            <h2 class="fw-bold mb-3" style="color:#f5d06f; text-shadow:0 0 6px black;">
                <?= htmlspecialchars($producto['nombre']) ?>
            </h2>

            <p class="descripcion mb-3"><?= nl2br(htmlspecialchars($producto['descripcion'])) ?></p>
            <p class="precio fs-4 fw-bold text-light">$<?= number_format($producto['precio'], 0, ',', '.') ?></p>

            <p class="stock mb-3">
                <?php if($cantidad>0): ?>
                    <span class="badge bg-success">Disponibles: <?= $cantidad ?></span>
                <?php else: ?>
                    <span class="badge bg-danger">AGOTADO</span>
                <?php endif; ?>
            </p>

            <?php if($cantidad>0): ?>
            <form id="add-to-cart-form" action="index.php?url=carrito/add<?= $keep ?>" method="post" class="mb-4">
                <input type="hidden" name="product_id" value="<?= $producto['id'] ?>">

                <div class="mb-3">
                    <label for="cantidad-input" class="form-label fw-semibold" style="color:#f5d06f;">Cantidad:</label>
                    <input type="number" id="cantidad-input" name="cantidad" value="1" min="1" max="<?= $cantidad ?>"
                           class="form-control bg-dark text-light border-warning" style="max-width:120px;" required>
                </div>

                <button type="submit" id="cart-button" class="btn btn-warning fw-bold">
                    🛒 Añadir al carrito
                </button>
                <span id="cart-confirm" class="ms-3 text-success fw-bold" style="display:none;">Añadido</span>
            </form>
            <?php endif; ?>

            <!-- Reseñas de otros usuarios -->
            <div class="bg-dark p-4 rounded shadow-lg flex-grow-1 mt-4">
                <h3 class="fw-bold mb-3" style="color:#f5d06f;">Reseñas de otros usuarios</h3>

                <div class="resenas-list">
                    <?php
                    require_once __DIR__ . '/../../models/Resena.php';
                    $resenas = Resena::getPorProducto($producto['id']);
                    if (count($resenas) === 0) {
                        echo "<p class='text-light'>Aún no hay reseñas para este producto.</p>";
                    } else {
                        foreach ($resenas as $r) {
                            echo "<div class='resena mb-3'>";
                            echo "<strong style='color:#f5d06f;'>" . htmlspecialchars($r['usuario']) . "</strong><br>";
                            echo "<span class='estrellas-show'>" . str_repeat('⭐', $r['calificacion']) . "</span><br>";
                            echo "<p class='text-light'>" . nl2br(htmlspecialchars($r['comentario'])) . "</p>";
                            echo "<small class='text-secondary'>" . $r['fecha'] . "</small>";
                            echo "<hr class='border-secondary'>";
                            echo "</div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background: #181616ff !important;
    }
    .producto-img {
        max-height: 400px;
        object-fit: contain;
        transition: transform .25s ease-in-out;
    }
    .producto-img:hover {
        transform: scale(1.04);
        filter: brightness(1.12);
    }

    /* Estrellas mejoradas */
    .estrellas, .estrellas-show {
        font-size: 1.4rem;
        color: gold;
        text-shadow: 0 0 8px rgba(255,215,0,0.9), 0 0 12px rgba(255,215,0,0.7);
        letter-spacing: 1px;
        font-weight: bold;
    }
    .estrellas:hover {
        transform: scale(1.04);
        filter: brightness(1.3);
    }
</style>
