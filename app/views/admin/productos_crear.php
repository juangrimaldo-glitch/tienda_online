<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Añadir Nuevo Producto</h2>

<form action="index.php?url=admin/guardarProducto" method="POST" enctype="multipart/form-data">

    <div class="mb-3">
        <label>Categoría</label>
        <select name="categoria" class="form-control" required>
            <option value="">Seleccione...</option>
            <?php foreach ($categorias as $c): ?>
                <option value="<?= $c['id'] ?>"><?= $c['nombre'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Descripción</label>
        <textarea name="descripcion" class="form-control" rows="3"></textarea>
    </div>

    <div class="mb-3">
        <label>Precio</label>
        <input type="number" step="0.01" name="precio" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Stock inicial</label>
        <input type="number" name="stock" min="0" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Imagen del producto</label>
        <input type="file" name="imagen" class="form-control" required>
    </div>

    <button class="btn btn-success" type="submit">Guardar</button>
    <a class="btn btn-secondary" href="index.php?url=admin/productos">Volver</a>
</form>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
