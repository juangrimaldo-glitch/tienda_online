<?php
require_once __DIR__ . '/../core/Database.php';

class Inventario
{
    public static function getCantidad($productoId)
    {
        $conn = Database::getConnection();

        if ($conn) {
            $stmt = $conn->prepare("SELECT cantidad FROM inventario WHERE producto_id = ?");
            $stmt->bind_param("i", $productoId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                return (int)$row['cantidad'];
            }
        }

        return 0; // Si no hay registro, cantidad = 0
    }
}
