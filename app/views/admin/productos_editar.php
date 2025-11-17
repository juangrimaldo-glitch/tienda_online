<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Editar Producto</h2>

<form action="index.php?url=admin/actualizarProducto" method="POST" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
    <input type="hidden" name="imagen_actual" value="<?= $producto['imagen'] ?>">

    <div class="mb-3">
        <label>Categoría</label>
        <select name="categoria" class="form-control" required>
            <?php foreach ($categorias as $c): ?>
                <option value="<?= $c['id'] ?>" <?= ($c['id'] == $producto['categoria_id']) ? 'selected' : '' ?>>
                    <?= $c['nombre'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" value="<?= $producto['nombre'] ?>" required>
    </div>

    <div class="mb-3">
        <label>Descripción</label>
        <textarea name="descripcion" class="form-control" rows="3"><?= $producto['descripcion'] ?></textarea>
    </div>

    <div class="mb-3">
        <label>Precio</label>
        <input type="number" step="0.01" name="precio" class="form-control" value="<?= $producto['precio'] ?>" required>
    </div>

    <div class="mb-3">
        <label>Stock</label>
        <input type="number" name="stock" min="0" class="form-control" value="<?= $stock ?>" required>
    </div>

    <div class="mb-3">
        <label>Imagen Actual</label>
        <br>
        <img src="<?= $producto['imagen'] ?>" width="120" height="120" style="object-fit:cover;">
        <br><br>
        <input type="file" name="imagen" class="form-control">
    </div>

    <button class="btn btn-success" type="submit">Actualizar</button>
    <a class="btn btn-secondary" href="index.php?url=admin/productos">Cancelar</a>
</form>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
