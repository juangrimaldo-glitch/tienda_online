<?php
require_once __DIR__ . '/../models/Carrito.php';
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Inventario.php';
require_once __DIR__ . '/../core/Database.php';

class CarritoController
{
    private function ensureAuth($noRedirectForAjax = false)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            $isXhr = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
            if ($noRedirectForAjax && $isXhr) return false;
            $keep = isset($_REQUEST['keepnav']) && $_REQUEST['keepnav'] == '1' ? '&keepnav=1' : '';
            header('Location: index.php?url=usuarios/login' . $keep);
            exit;
        }
        return $_SESSION['user_id'];
    }

    public function add()
    {
        $userId = $this->ensureAuth(true);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }

        $id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $qty = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;

        $producto = Producto::find($id);
        if (!$producto) {
            header('Location: index.php');
            exit;
        }

        // Verificar stock disponible
        $stockDisponible = Inventario::getCantidad($id);

        // Ajustar cantidad a lo disponible
        if ($qty > $stockDisponible) $qty = $stockDisponible;

        if ($qty <= 0) {
            header('Location: index.php?url=producto/detalle&id=' . $id);
            exit;
        }

        // Agregar al carrito
        Carrito::add($producto, $qty);

        // Reducir stock correctamente
        $nuevaCantidad = $stockDisponible - $qty;
        Inventario::update($id, $nuevaCantidad);

        $keep = isset($_REQUEST['keepnav']) && $_REQUEST['keepnav'] == '1' ? '&keepnav=1' : '';
        header('Location: index.php?url=carrito/index' . $keep);
        exit;
    }

    public function remove()
    {
        $userId = $this->ensureAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?url=carrito/index');
            exit;
        }

        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : null;

        if ($productId) {
            $item = Carrito::getItemByProduct($productId);
            if ($item) {
                // Devolver cantidad al inventario
                $stockActual = Inventario::getCantidad($productId);
                Inventario::update($productId, $stockActual + $item['cantidad']);

                // Remover del carrito
                Carrito::removeByProduct($productId);
            }
        }

        $keep = isset($_REQUEST['keepnav']) && $_REQUEST['keepnav'] == '1' ? '&keepnav=1' : '';
        header('Location: index.php?url=carrito/index' . $keep);
        exit;
    }

    public function index()
    {
        $userId = $this->ensureAuth();
        $items = Carrito::all();
        require_once __DIR__ . '/../views/carrito/index.php';
    }

    public function count()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $totalProductos = 0;
        $items = $_SESSION['carrito'] ?? [];
        foreach ($items as $it) {
            $totalProductos += $it['cantidad'] ?? 1;
        }

        return $totalProductos;
    }
}
