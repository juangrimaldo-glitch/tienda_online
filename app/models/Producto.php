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

    public static function byCategoria($categoriaId)
    {
        $conn = Database::getConnection();

        if ($conn) {
            $stmt = $conn->prepare("SELECT * FROM productos WHERE categoria_id = ?");
            $stmt->bind_param("i", $categoriaId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                return $result->fetch_all(MYSQLI_ASSOC);
            }
        }
        return [];
    }

    public static function allWithStock()
    {
        $conn = Database::getConnection();
        $query = "SELECT p.*, i.cantidad AS stock, c.nombre AS categoria
                  FROM productos p
                  LEFT JOIN inventario i ON p.id = i.producto_id
                  LEFT JOIN categorias c ON p.categoria_id = c.id";
        $result = $conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function create($categoria_id, $nombre, $descripcion, $imagen, $precio)
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("INSERT INTO productos (categoria_id, nombre, descripcion, imagen, precio)
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssd", $categoria_id, $nombre, $descripcion, $imagen, $precio);
        $stmt->execute();
        return $conn->insert_id;
    }

    public static function update($id, $categoria_id, $nombre, $descripcion, $imagen, $precio)
    {
        $conn = Database::getConnection();
        if ($imagen) {
            $stmt = $conn->prepare("UPDATE productos SET categoria_id=?, nombre=?, descripcion=?, imagen=?, precio=? WHERE id=?");
            $stmt->bind_param("isssdi", $categoria_id, $nombre, $descripcion, $imagen, $precio, $id);
        } else {
            $stmt = $conn->prepare("UPDATE productos SET categoria_id=?, nombre=?, descripcion=?, precio=? WHERE id=?");
            $stmt->bind_param("issdi", $categoria_id, $nombre, $descripcion, $precio, $id);
        }
        return $stmt->execute();
    }

    public static function delete($id)
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("DELETE FROM productos WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
