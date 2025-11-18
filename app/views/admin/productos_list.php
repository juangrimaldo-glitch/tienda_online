<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<style>
    body {
        background-color: #111111ff; 
        color: #f8d06c;
    }

    .table-container {
        background: #000000ff;
        border: 2px solid #b8860b;
        box-shadow: 0 0 18px rgba(184, 134, 11, 0.35);
        border-radius: 10px;
        overflow: hidden;
    }

    table {
        margin: 0;
        color: #2b2b2b; /* Texto oscuro para buen contraste */
        font-weight: 500;
    }

    .table thead {
        background-color: #b8860b !important;
        color: #0d0d0d !important;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .table tbody tr {
        background-color: #ffffff;
        border-color: #d4af37 !important;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f7f7f7;
    }

    .table tbody tr:hover {
        background-color: #fff6d5;
        transition: .2s ease-in-out;
        cursor: pointer;
    }

    .table tbody td, 
    .table tbody th {
        border-color: #c5981c !important;
    }

    .btn-danger {
        background-color: #8b0000;
        border: none;
    }
    .btn-danger:hover {
        background-color: #a30000;
    }

    .btn-warning {
        background-color: #d4a017;
        border: none;
        color: black;
        font-weight: bold;
    }

    .btn-warning:hover {
        background-color: #e6b325;
        color: black;
    }

    img.rounded.shadow {
        border: 2px solid #b8860b;
        object-fit: cover;
    }
</style>


<div class="container py-4">
    <h2 class="text-center fw-bold mb-4">📦 Gestión de Productos</h2>

    <div class="text-end mb-3">
        <a class="btn btn-warning" href="index.php?url=admin/crearProducto">➕ Añadir Producto</a>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table align-middle table-bordered table-striped m-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><img src="<?= $p['imagen'] ?>" width="70" height="70" class="rounded shadow"></td>
                        <td><?= $p['nombre'] ?></td>
                        <td><?= $p['categoria'] ?></td>
                        <td class="fw-semibold">$<?= number_format($p['precio'], 0) ?></td>
                        <td><?= $p['stock'] ?></td>
                        <td class="text-center">
                            <a class="btn btn-warning btn-sm" href="index.php?url=admin/editarProducto/<?= $p['id'] ?>">✏️ Editar</a>
                            <a class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminarlo?')" href="index.php?url=admin/eliminarProducto/<?= $p['id'] ?>">🗑 Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
