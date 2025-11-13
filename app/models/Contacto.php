<?php
require_once __DIR__ . '/../core/Database.php';

class Contacto
{
    public static function crear($nombre, $email, $telefono, $mensaje)
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("INSERT INTO contactos (nombre, email, telefono, mensaje, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $nombre, $email, $telefono, $mensaje);
        return $stmt->execute();
    }
}
