<?php
class Database
{
    private static $conn = null;

    public static function getConnection()
    {
        if (self::$conn === null) {
            $servidor = "127.0.0.1";      // o "localhost"
            $usuario = "root";            // tu usuario de MySQL
            $password = "";               // tu contraseña (si tienes)
            $base_datos = "tienda_online"; // tu base de datos

            self::$conn = new mysqli($servidor, $usuario, $password, $base_datos);

            if (self::$conn->connect_error) {
                error_log("Error de conexión: " . self::$conn->connect_error);
                return null;
            }
        }

        return self::$conn;
    }
}
?>


