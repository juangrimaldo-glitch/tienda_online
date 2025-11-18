<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<style>
    body {
        background-color: #0d0d0d;
        color: #f8d06c;
    }
    .card-custom {
        background: #1a1a1a;
        border: 1px solid #b8860b;
        box-shadow: 0 0 15px rgba(184, 134, 11, 0.3);
    }
    .form-control, .form-select {
        background-color: #262626;
        border: 1px solid #b8860b;
        color: #f8d06c;
    }
</style>

<div class="container py-4">
    <h2 class="text-center fw-bold mb-4">✏️ Editar Producto</h2>

    <form action="index.php?url=admin/actualizarProducto" method="POST" enctype="multipart/form-data" class="card-custom p-4 rounded">

        <input type="hidden" name="id" value="<?= $producto['id'] ?>">
        <input type="hidden" name="imagen_actual" value="<?= $producto['imagen'] ?>">

        <div class="mb-3">
            <label class="fw-semibold">Categoría</label>
            <select name="categoria" class="form-select" required>
                <?php foreach ($categorias as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= ($c['id'] == $producto['categoria_id']) ? 'selected' : '' ?>>
                        <?= $c['nombre'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Nombre</label>
            <input type="text" name="nombre" value="<?= $producto['nombre'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3"><?= $producto['descripcion'] ?></textarea>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Precio</label>
            <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Stock</label>
            <input type="number" name="stock" min="0" value="<?= $stock ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="fw-semibold d-block">Imagen Actual</label>
            <img src="<?= $producto['imagen'] ?>" width="120" height="120" class="rounded border mb-2" style="object-fit:cover;">
            <input type="file" name="imagen" class="form-control mt-2">
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-success w-50" type="submit">Actualizar</button>
            <a class="btn btn-secondary w-50" href="index.php?url=admin/productos">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
