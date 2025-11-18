<?php // $items provisto por el controlador ?>

<style>
    body {
        background-color: #1c1b1b; /* Fondo oscuro elegante */
    }
    .carrito-title {
        color: #f5d06f;
        text-shadow: 0 0 6px black;
    }
    .table thead th {
        color: #000;
        font-weight: bold;
    }
    .table-dark td, .table-dark th {
        color: #f8f9fa; /* texto claro */
    }
    .table-dark tfoot td {
        background-color: #343a40;
        color: #f5d06f;
        font-weight: bold;
    }
</style>

<div class="container py-5">
    <h2 class="fw-bold mb-4 text-center carrito-title">
        Carrito de compra
    </h2>

    <?php if (empty($items)): ?>
        <div class="alert alert-info text-center fw-semibold shadow">
            Tu carrito está vacío.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover align-middle shadow-lg border border-warning">
                <thead class="table-warning">
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    require_once __DIR__ . '/../../models/Inventario.php';
                    $total = 0; 
                    foreach ($items as $it):
                        if (isset($it['producto']) && is_array($it['producto'])) {
                            $p = $it['producto'];
                            $name = $p['nombre'] ?? ($p['name'] ?? 'Producto');
                            $price = isset($p['precio']) ? (float)$p['precio'] : (isset($p['price']) ? (float)$p['price'] : 0.0);
                            $qty = isset($it['cantidad']) ? (int)$it['cantidad'] : 1;
                            $prodId = $p['id'] ?? null;
                        } else {
                            $name = $it['nombre'] ?? ($it['product_name'] ?? 'Producto');
                            $price = isset($it['precio']) ? (float)$it['precio'] : (isset($it['price']) ? (float)$it['price'] : 0.0);
                            $qty = isset($it['cantidad']) ? (int)$it['cantidad'] : (isset($it['quantity']) ? (int)$it['quantity'] : 1);
                            $prodId = $it['producto']['id'] ?? $it['id'] ?? null;
                        }
                        $subtotal = $price * $qty;
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($name) ?></td>
                            <td>$<?= number_format($price,2) ?></td>
                            <td><?= $qty ?></td>
                            <td>$<?= number_format($subtotal,2) ?></td>
                            <td>
                                <?php $keep = isset($_GET['keepnav']) && $_GET['keepnav']=='1' ? '&keepnav=1' : ''; ?>
                                <form method="post" action="index.php?url=carrito/remove<?= $keep ?>" class="d-inline">
                                    <?php if (isset($it['id'])): ?>
                                        <input type="hidden" name="item_id" value="<?= (int)$it['id'] ?>">
                                    <?php elseif ($prodId): ?>
                                        <input type="hidden" name="product_id" value="<?= (int)$prodId ?>">
                                    <?php endif; ?>
                                    <button type="submit" class="btn btn-sm btn-danger fw-bold shadow-sm">Quitar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end">Total</td>
                        <td>$<?= number_format($total,2) ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <?php
        $mensaje = "Hola, quiero comprar las siguientes plantas:%0A";
        foreach ($items as $item) {
            $nombre = isset($item['nombre']) ? $item['nombre'] : ($item['producto']['nombre'] ?? 'Producto');
            $precio = isset($item['precio']) ? $item['precio'] : ($item['producto']['precio'] ?? 0);
            $cantidad = isset($item['cantidad']) ? $item['cantidad'] : 1;
            $mensaje .= "- " . urlencode($nombre) . " x" . $cantidad . " = $" . number_format($precio * $cantidad, 0, ',', '.') . "%0A";
        }
        $mensaje .= "%0ATotal: $" . number_format($total, 0, ',', '.');
        $telefono = "3113941047";
        $urlWhatsapp = "https://wa.me/57{$telefono}?text={$mensaje}";
        ?>
        <div class="text-center mt-4">
            <a href="<?= $urlWhatsapp ?>" target="_blank" class="btn btn-success fw-bold px-4 py-2 shadow-lg">
                🛒 Comprar por WhatsApp
            </a>
        </div>
    <?php endif; ?>
</div>
