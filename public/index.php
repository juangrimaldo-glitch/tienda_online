<?php
// Front controller mínimo: maneja index.php?url=controlador/accion/param
$plain = isset($_GET['plain']) && $_GET['plain'] == '1';
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
if (!$plain) {
	require_once __DIR__ . '/../app/views/layouts/header.php';
}
if ($url === '') {
	// Por defecto mostrar la lista de productos
	require_once __DIR__ . '/../app/controllers/ProductoController.php';
	$controller = new ProductoController();
	$controller->index();
} else {
	$parts = explode('/', $url);
	$controllerName = ucfirst($parts[0]) . 'Controller';
	$action = isset($parts[1]) && $parts[1] !== '' ? $parts[1] : 'index';
	$param = isset($parts[2]) ? $parts[2] : null;

	$controllerFile = __DIR__ . '/../app/controllers/' . $controllerName . '.php';
	if (file_exists($controllerFile)) {
		require_once $controllerFile;
		if (class_exists($controllerName)) {
			$controller = new $controllerName();
			if (method_exists($controller, $action)) {
				if ($param !== null) {
					$controller->{$action}($param);
				} else {
					$controller->{$action}();
				}
			} else {
				echo "<h2>Acción no encontrada: $action</h2>";
			}
		} else {
			echo "<h2>Controlador no encontrado: $controllerName</h2>";
		}
	} else {
		echo "<h2>Ruta no encontrada</h2>";
	}
}

if (!$plain) {
	require_once __DIR__ . '/../app/views/layouts/footer.php';
}
?>

