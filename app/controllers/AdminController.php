<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Categoria.php';
require_once __DIR__ . '/../models/Inventario.php';

class AdminController
{
    private function verificarAcceso()
    {
        if (session_status() == PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user']) || $_SESSION['user']['rol_nombre'] !== 'admin') {
            header('Location: index.php?url=usuarios/login');
            exit;
        }
    }

    public function index()
    {
        $this->verificarAcceso();
        return $this->productos();
    }

    public function productos()
    {
        $this->verificarAcceso();
        $productos = Producto::allWithStock();
        require_once __DIR__ . '/../views/admin/productos_list.php';
    }

    public function crearProducto()
    {
        $this->verificarAcceso();
        $categorias = Categoria::all();
        require_once __DIR__ . '/../views/admin/productos_crear.php';
    }

    public function guardarProducto()
    {
        $this->verificarAcceso();

        if (!isset($_POST['nombre'], $_POST['precio'], $_POST['categoria'], $_POST['stock'])) {
            die("Error al guardar producto. Datos incompletos.");
        }

        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'] ?? '';
        $precio = $_POST['precio'];
        $categoria = $_POST['categoria'];
        $stock = $_POST['stock'];

        // Imagen
        $imagen = null;
        if (!empty($_FILES['imagen']['name'])) {
            $nombreArchivo = uniqid() . "_" . basename($_FILES['imagen']['name']);
            $ruta = 'images/' . $nombreArchivo;
            move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . '/../../public/' . $ruta);
            $imagen = $ruta;
        }

        $idProducto = Producto::create($categoria, $nombre, $descripcion, $imagen, $precio);
        Inventario::create($idProducto, $stock);

        header('Location: index.php?url=admin/productos');
        exit;
    }

    public function editarProducto($id)
    {
        $this->verificarAcceso();

        if (!$id) {
            die("Error: No se proporcionó el ID del producto.");
        }

        $producto = Producto::find($id);
        if (!$producto) {
            die("Error: Producto no encontrado.");
        }

        $categorias = Categoria::all();
        $stock = Inventario::getCantidad($id);

        require_once __DIR__ . '/../views/admin/productos_editar.php';
    }

    public function actualizarProducto()
    {
        $this->verificarAcceso();

        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $categoria = $_POST['categoria'];
        $stock = $_POST['stock'];

        $imagen = $_POST['imagen_actual'];
        if (!empty($_FILES['imagen']['name'])) {
            $nombreArchivo = uniqid() . "_" . basename($_FILES['imagen']['name']);
            $ruta = 'images/' . $nombreArchivo;
            move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . '/../../public/' . $ruta);
            $imagen = $ruta;
        }

        Producto::update($id, $categoria, $nombre, $descripcion, $imagen, $precio);
        Inventario::update($id, $stock);

        header('Location: index.php?url=admin/productos');
        exit;
    }

    public function eliminarProducto($id)
    {
        $this->verificarAcceso();
        if (!$id) die("ID no proporcionado");

        Inventario::delete($id);
        Producto::delete($id);

        header('Location: index.php?url=admin/productos');
        exit;
    }
}
