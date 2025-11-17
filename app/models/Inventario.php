<?php
require_once __DIR__ . '/../core/Database.php';

class Inventario
{
    public static function getCantidad($productoId)
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT cantidad FROM inventario WHERE producto_id = ?");
        $stmt->bind_param("i", $productoId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return (int)$row['cantidad'];
        }
        return 0;
    }

    public static function create($producto_id, $cantidad)
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("INSERT INTO inventario (producto_id, cantidad, ultima_actualizacion)
                                VALUES (?, ?, NOW())");
        $stmt->bind_param("ii", $producto_id, $cantidad);
        return $stmt->execute();
    }

    public static function update($producto_id, $cantidad)
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("UPDATE inventario SET cantidad=?, ultima_actualizacion=NOW() WHERE producto_id=?");
        $stmt->bind_param("ii", $cantidad, $producto_id);
        return $stmt->execute();
    }

    public static function delete($producto_id)
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("DELETE FROM inventario WHERE producto_id=?");
        $stmt->bind_param("i", $producto_id);
        return $stmt->execute();
    }
}
