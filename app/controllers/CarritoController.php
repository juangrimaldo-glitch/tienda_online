<?php
require_once __DIR__ . '/../models/Carrito.php';
require_once __DIR__ . '/../models/Producto.php';
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
		$pxhr = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

		if ($userId === false && $pxhr) {
			header('HTTP/1.1 401 Unauthorized');
			exit;
		}

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			header('Location: index.php');
			exit;
		}

		$id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
		$qty = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;
		$producto = Producto::find($id);

		if ($producto) {
			$mysqli = Database::getConnection();
			if ($mysqli) {
				try {
					$check = $mysqli->prepare('SELECT id, nombre, descripcion, imagen, precio FROM productos WHERE id = ? LIMIT 1');
					$check->bind_param("i", $producto['id']);
					$check->execute();
					$result = $check->get_result();
					$row = $result->fetch_assoc();

					if ($row) {
						$producto_id_db = $row['id'];
						$nombre = $row['nombre'];
						$descripcion = $row['descripcion'];
						$imagen = $row['imagen'];
						$precio = $row['precio'];
					} else {
						$producto_id_db = null;
						$nombre = $producto['nombre'] ?? '';
						$descripcion = $producto['descripcion'] ?? '';
						$imagen = $producto['imagen'] ?? '';
						$precio = $producto['precio'] ?? 0.00;
					}

					$sql = "INSERT INTO carrito_items (user_id, producto_id, nombre, descripcion, imagen, precio, cantidad) 
					        VALUES (?, ?, ?, ?, ?, ?, ?)";
					$stmt = $mysqli->prepare($sql);
					$stmt->bind_param(
						"iisssdi",
						$userId,
						$producto_id_db,
						$nombre,
						$descripcion,
						$imagen,
						$precio,
						$qty
					);
					$stmt->execute();

				} catch (Exception $e) {
					Carrito::add($producto, max(1, $qty));
				}
			} else {
				Carrito::add($producto, max(1, $qty));
			}
		}

		$keep = isset($_REQUEST['keepnav']) && $_REQUEST['keepnav'] == '1' ? '&keepnav=1' : '';
		$explicitCart = (isset($_POST['redirect']) && $_POST['redirect'] === 'cart') || (isset($_POST['go_to_cart']) && $_POST['go_to_cart']);
		if ($explicitCart) {
			header('Location: index.php?url=carrito/index' . $keep);
			exit;
		}

		if (!empty($_SERVER['HTTP_REFERER'])) {
			$ref = $_SERVER['HTTP_REFERER'];
			$refHost = parse_url($ref, PHP_URL_HOST);
			if ($refHost === ($_SERVER['HTTP_HOST'] ?? '')) {
				header('Location: ' . $ref);
				exit;
			}
		}

		if ($pxhr) {
			header('HTTP/1.1 204 No Content');
			exit;
		}

		header('Location: index.php?url=producto/index' . $keep);
		exit;
	}

	public function index()
	{
		$userId = $this->ensureAuth();
		$mysqli = Database::getConnection();
		if ($mysqli) {
			$stmt = $mysqli->prepare("SELECT * FROM carrito_items WHERE user_id = ?");
			$stmt->bind_param("i", $userId);
			$stmt->execute();
			$result = $stmt->get_result();
			$items = $result->fetch_all(MYSQLI_ASSOC);
		} else {
			$items = Carrito::all();
		}
		require_once __DIR__ . '/../views/carrito/index.php';
	}

	public function remove()
	{
		$userId = $this->ensureAuth();

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			header('Location: index.php?url=carrito/index');
			exit;
		}

		$mysqli = Database::getConnection();

		if (!empty($_POST['item_id']) && $mysqli) {
			$itemId = (int)$_POST['item_id'];
			$stmt = $mysqli->prepare('DELETE FROM carrito_items WHERE id = ? AND user_id = ?');
			$stmt->bind_param("ii", $itemId, $userId);
			$stmt->execute();
		} elseif (!empty($_POST['product_id'])) {
			$productId = (int)$_POST['product_id'];
			if ($mysqli) {
				$stmt = $mysqli->prepare('DELETE FROM carrito_items WHERE producto_id = ? AND user_id = ?');
				$stmt->bind_param("ii", $productId, $userId);
				$stmt->execute();
			} else {
				Carrito::initialize();
				foreach ($_SESSION['carrito'] as $k => $it) {
					if (isset($it['producto']) && isset($it['producto']['id']) && $it['producto']['id'] == $productId) {
						unset($_SESSION['carrito'][$k]);
					}
				}
			}
		}

		$keep = isset($_REQUEST['keepnav']) && $_REQUEST['keepnav'] == '1' ? '&keepnav=1' : '';
		header('Location: index.php?url=carrito/index' . $keep);
		exit;
	}

	public function count()
	{
		if (session_status() === PHP_SESSION_NONE) session_start();

		$totalProductos = 0;
		$userId = $_SESSION['user_id'] ?? null;
		$mysqli = Database::getConnection();

		if ($mysqli && $userId) {
			$stmt = $mysqli->prepare("SELECT SUM(cantidad) AS total FROM carrito_items WHERE user_id = ?");
			$stmt->bind_param("i", $userId);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$totalProductos = $row && $row['total'] ? (int)$row['total'] : 0;
		} else {
			$items = $_SESSION['carrito'] ?? [];
			foreach ($items as $it) {
				if (isset($it['cantidad'])) {
					$totalProductos += (int)$it['cantidad'];
				} elseif (isset($it['quantity'])) {
					$totalProductos += (int)$it['quantity'];
				} else {
					$totalProductos++;
				}
			}
		}

		return $totalProductos;
	}
}