<?php // $items provisto por controlador ?>
<h2>Carrito de compra</h2>
<?php if (empty($items)): ?>
    <p>Tu carrito está vacío.</p>
<?php else: ?>
    <table>
        <thead>
            <tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th><th>Acción</th></tr>
        </thead>
        <tbody>
            <?php $total = 0; foreach ($items as $it):
                // Soportar dos formatos de item:
                // 1) sesión: ['producto' => [...], 'cantidad' => N]
                // 2) BD: ['nombre'=>..., 'precio'=>..., 'cantidad'=>...]
                if (isset($it['producto']) && is_array($it['producto'])) {
                    $p = $it['producto'];
                    $name = $p['nombre'] ?? ($p['name'] ?? 'Producto');
                    $price = isset($p['precio']) ? (float)$p['precio'] : (isset($p['price']) ? (float)$p['price'] : 0.0);
                    $qty = isset($it['cantidad']) ? (int)$it['cantidad'] : 1;
                } else {
                    $name = $it['nombre'] ?? ($it['product_name'] ?? 'Producto');
                    $price = isset($it['precio']) ? (float)$it['precio'] : (isset($it['price']) ? (float)$it['price'] : 0.0);
                    $qty = isset($it['cantidad']) ? (int)$it['cantidad'] : (isset($it['quantity']) ? (int)$it['quantity'] : 1);
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
                            <?php elseif (isset($it['producto']) && isset($it['producto']['id'])): ?>
                                <input type="hidden" name="product_id" value="<?= (int)$it['producto']['id'] ?>">
                            <?php endif; ?>
                            <button type="submit" class="boton">Quitar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr><td colspan="3">Total</td><td>$<?= number_format($total,2) ?></td></tr>
        </tfoot>
    </table>
<?php endif; ?>

<style>
table{width:100%;border-collapse:collapse}
td,th{border:1px solid #ddd;padding:8px}
</style>
