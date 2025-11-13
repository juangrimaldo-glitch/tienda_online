<?php
require_once __DIR__ . '/../models/Contacto.php';

class ContactoController
{
    public function index()
    {
        require_once __DIR__ . '/../views/contacto/index.php';
    }

    public function enviar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $telefono = $_POST['telefono'];
            $mensaje = $_POST['mensaje'];

            if (Contacto::crear($nombre, $email, $telefono, $mensaje)) {
                echo "<script>alert('Mensaje enviado correctamente.'); window.location='index.php';</script>";
            } else {
                echo "<script>alert('Error al enviar el mensaje.'); window.history.back();</script>";
            }
        }
    }
}
