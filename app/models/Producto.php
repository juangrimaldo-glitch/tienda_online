<?php
require_once __DIR__ . '/../core/Database.php';

class Producto
{
    public static function all()
    {
        $conn = Database::getConnection();

        if ($conn) {
            $result = $conn->query("SELECT * FROM productos");

            if ($result && $result->num_rows > 0) {
                return $result->fetch_all(MYSQLI_ASSOC);
            }
        }

        return [];
    }

    public static function find($id)
    {
        $conn = Database::getConnection();

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado && $resultado->num_rows > 0) {
                return $resultado->fetch_assoc();
            }
        }

        return null;
    }
}
?>


