<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Gestión de Productos</h2>
<a class="btn btn-primary" href="index.php?url=admin/crearProducto">Añadir Producto</a>
<br><br>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($productos as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><img src="<?= $p['imagen'] ?>" width="70" height="70" style="object-fit:cover;"></td>
                <td><?= $p['nombre'] ?></td>
                <td><?= $p['categoria'] ?></td>
                <td>$<?= number_format($p['precio'], 0) ?></td>
                <td><?= $p['stock'] ?></td>
                <td>
                    <a class="btn btn-warning btn-sm" href="index.php?url=admin/editarProducto/<?= $p['id'] ?>">Editar</a>
                    <a class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminarlo?')" href="index.php?url=admin/eliminarProducto/<?= $p['id'] ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>


