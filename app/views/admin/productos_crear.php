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
    .form-control::placeholder {
        color: #d3c288;
    }
</style>

<div class="container py-4">
    <h2 class="text-center fw-bold mb-4">➕ Añadir Nuevo Producto</h2>

    <form action="index.php?url=admin/guardarProducto" method="POST" enctype="multipart/form-data" class="card-custom p-4 rounded">

        <div class="mb-3">
            <label class="fw-semibold">Categoría</label>
            <select name="categoria" class="form-select" required>
                <option value="">Seleccione...</option>
                <?php foreach ($categorias as $c): ?>
                    <option value="<?= $c['id'] ?>"><?= $c['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Stock inicial</label>
            <input type="number" name="stock" min="0" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Imagen del producto</label>
            <input type="file" name="imagen" class="form-control" required>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-success w-50" type="submit">Guardar</button>
            <a class="btn btn-secondary w-50" href="index.php?url=admin/productos">Volver</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
