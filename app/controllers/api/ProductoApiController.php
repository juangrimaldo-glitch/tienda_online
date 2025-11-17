<?php
require_once __DIR__ . '/../../models/Producto.php';

class ProductoApiController {

    public function listar() {
        header('Content-Type: application/json');
        echo json_encode(Producto::all());
    }

    public function ver($id) {
        header('Content-Type: application/json');
        $producto = Producto::find($id);

        if ($producto) {
            echo json_encode($producto);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Producto no encontrado"]);
        }
    }

    public function crear() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);

        // Extraer campos del array
        $categoria_id = $data['categoria_id'] ?? null;
        $nombre       = $data['nombre'] ?? null;
        $descripcion  = $data['descripcion'] ?? null;
        $imagen       = $data['imagen'] ?? null;
        $precio       = $data['precio'] ?? null;

        $resultado = Producto::create($categoria_id, $nombre, $descripcion, $imagen, $precio);

        echo json_encode([
            "success" => $resultado ? true : false,
            "message" => $resultado ? "Producto creado" : "Error al crear"
        ]);
    }

    public function actualizar($id) {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);

        // Extraer campos del array
        $categoria_id = $data['categoria_id'] ?? null;
        $nombre       = $data['nombre'] ?? null;
        $descripcion  = $data['descripcion'] ?? null;
        $imagen       = $data['imagen'] ?? null; // puede ser null
        $precio       = $data['precio'] ?? null;

        $resultado = Producto::update($id, $categoria_id, $nombre, $descripcion, $imagen, $precio);

        echo json_encode([
            "success" => $resultado ? true : false,
            "message" => $resultado ? "Producto actualizado" : "Error al actualizar"
        ]);
    }

    public function eliminar($id) {
        header('Content-Type: application/json');

        $resultado = Producto::delete($id);

        echo json_encode([
            "success" => $resultado ? true : false,
            "message" => $resultado ? "Producto eliminado" : "Error al eliminar"
        ]);
    }
}

