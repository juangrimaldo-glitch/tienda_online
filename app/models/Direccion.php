<?php
require_once __DIR__ . '/../core/Database.php';

class Direccion
{
    public static function crear($userId, $ciudad, $departamento)
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("INSERT INTO direcciones (user_id, ciudad, departamento, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iss", $userId, $ciudad, $departamento);
        $stmt->execute();
        $stmt->close();
    }

    public static function ultimaPorUsuario($userId)
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM direcciones WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
