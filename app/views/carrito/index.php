<?php // $items provisto por el controlador ?>
<h2>Carrito de compra</h2>

<?php if (empty($items)): ?>
    <p>Tu carrito está vacío.</p>
<?php else: ?>
    <table>
        <thead>
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
                // Soportar dos formatos de item:
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
                        <form method="post" action="index.php?url=carrito/remove<?= $keep ?>" style="display:inline">
                            <?php if (isset($it['id'])): ?>
                                <input type="hidden" name="item_id" value="<?= (int)$it['id'] ?>">
                            <?php elseif ($prodId): ?>
                                <input type="hidden" name="product_id" value="<?= (int)$prodId ?>">
                            <?php endif; ?>
                            <button type="submit" class="boton">Quitar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Total</td>
                <td>$<?= number_format($total,2) ?></td>
            </tr>
        </tfoot>
    </table>

    <?php
    // ✅ Mensaje de WhatsApp con items
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
    <a href="<?= $urlWhatsapp ?>" target="_blank" class="boton comprar-whatsapp">
        🛒 Comprar por WhatsApp
    </a>
<?php endif; ?>

<style>
table { width:100%; border-collapse:collapse; margin-top:15px; }
td, th { border:1px solid #ddd; padding:8px; text-align:left; }
tfoot td { font-weight:bold; }
.boton {
    background-color:#007BFF;
    color:white;
    border:none;
    padding:5px 10px;
    border-radius:4px;
    cursor:pointer;
}
.boton:hover { background-color:#0056b3; }
.comprar-whatsapp {
    display:inline-block;
    background-color:#25D366;
    color:white;
    padding:10px 20px;
    text-decoration:none;
    border-radius:6px;
    font-weight:bold;
    margin-top:15px;
}
.comprar-whatsapp:hover { background-color:#1DA851; }
</style>
