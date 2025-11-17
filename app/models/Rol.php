<?php
require_once __DIR__ . '/../core/Database.php';

class Rol
{
    public static function all()
    {
        $conn = Database::getConnection();
        $result = $conn->query("SELECT * FROM roles");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public static function find($id)
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM roles WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_assoc() : null;
    }
}
