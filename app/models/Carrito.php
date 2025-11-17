<?php
class Carrito
{
    public static function initialize()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
    }

    public static function add($producto, $cantidad = 1)
    {
        self::initialize();
        $id = $producto['id'];

        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad'] += $cantidad;
        } else {
            $_SESSION['carrito'][$id] = [
                'producto' => $producto,
                'cantidad' => $cantidad
            ];
        }
    }

    public static function all()
    {
        self::initialize();
        return $_SESSION['carrito'];
    }

    public static function clear()
    {
        self::initialize();
        $_SESSION['carrito'] = [];
    }

    public static function getItemByProduct($producto_id)
    {
        self::initialize();
        return $_SESSION['carrito'][$producto_id] ?? null;
    }

    public static function removeByProduct($producto_id)
    {
        self::initialize();
        if (isset($_SESSION['carrito'][$producto_id])) {
            unset($_SESSION['carrito'][$producto_id]);
        }
    }
}
