<?php
// Habilitar buffer de salida para evitar errores de cabeceras
ob_start();

// Front controller con soporte MVC y API REST

$plain = isset($_GET['plain']) && $_GET['plain'] == '1';
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$parts = explode('/', $url);

// =========================
// 1️⃣ Detectar si es API
// =========================
if (isset($parts[0]) && $parts[0] === 'api') {
    $apiControllerName = isset($parts[1]) ? ucfirst($parts[1]) . 'ApiController' : null;
    $apiAction = isset($parts[2]) && $parts[2] !== '' ? $parts[2] : 'listar';
    $apiParam = isset($parts[3]) ? $parts[3] : null;

    $apiControllerFile = __DIR__ . '/../app/controllers/api/' . $apiControllerName . '.php';

    if ($apiControllerName && file_exists($apiControllerFile)) {
        require_once $apiControllerFile;

        if (class_exists($apiControllerName)) {
            $apiController = new $apiControllerName();

            if (method_exists($apiController, $apiAction)) {
                if ($apiParam !== null) {
                    $apiController->{$apiAction}($apiParam);
                } else {
                    $apiController->{$apiAction}();
                }
            } else {
                http_response_code(404);
                echo json_encode(["error" => "API acción no encontrada"]);
            }
        } else {
            http_response_code(404);
            echo json_encode(["error" => "API controlador inválido"]);
        }
    } else {
        http_response_code(404);
        echo json_encode(["error" => "API ruta no encontrada"]);
    }

    // Finalizar correctamente cualquier contenido pendiente antes de salir
    ob_end_flush();
    exit;
}

// =============================================================
// 2️⃣ Sistema MVC tradicional (vista web normal - no API)
// =============================================================

if (!$plain) {
    require_once __DIR__ . '/../app/views/layouts/header.php';
}

if ($url === '') {
    require_once __DIR__ . '/../app/controllers/ProductoController.php';
    $controller = new ProductoController();
    $controller->index();
} else {
    $controllerName = ucfirst($parts[0]) . 'Controller';
    $action = isset($parts[1]) && $parts[1] !== '' ? $parts[1] : 'index';
    $param = isset($parts[2]) ? $parts[2] : null;

    $controllerFile = __DIR__ . '/../app/controllers/' . $controllerName . '.php';

    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        
        if (class_exists($controllerName)) {
            $controller = new $controllerName();
            if (method_exists($controller, $action)) {
                ($param !== null) ? $controller->{$action}($param) : $controller->{$action}();
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

// Enviar toda la salida pendiente
ob_end_flush();
?>
