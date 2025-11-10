<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Categoria.php';

class ProductoController
{
    public function index()
    {
        $categorias = Categoria::all();

        // 🟢 Si existe un filtro de categoría en la URL, lo usamos
        $categoriaId = isset($_GET['categoria']) && $_GET['categoria'] !== ''
            ? (int) $_GET['categoria']
            : null;

        if ($categoriaId) {
            $productos = Producto::byCategoria($categoriaId);
        } else {
            $productos = Producto::all();
        }

        require_once __DIR__ . '/../views/productos/index.php';
    }

    public function detalle($id = null)
    {
        if ($id === null) {
            header('Location: /public/index.php?url=producto/index');
            exit;
        }
        $producto = Producto::find($id);
        if (!$producto) {
            echo "Producto no encontrado";
            return;
        }
        require_once __DIR__ . '/../views/productos/detalle.php';
    }
}
