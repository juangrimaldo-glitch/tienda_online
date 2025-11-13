<?php
require_once __DIR__ . '/../core/Database.php';

class Resena
{
    public static function getPorProducto($productoId)
    {
        $conn = Database::getConnection();
        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM resenas WHERE producto_id = ? ORDER BY fecha DESC");
            $stmt->bind_param("i", $productoId);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public static function crear($productoId, $usuario, $comentario, $calificacion)
    {
        $conn = Database::getConnection();
        if ($conn) {
            $stmt = $conn->prepare("INSERT INTO resenas (producto_id, usuario, comentario, calificacion) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("issi", $productoId, $usuario, $comentario, $calificacion);
            return $stmt->execute();
        }
        return false;
    }
}
?>
