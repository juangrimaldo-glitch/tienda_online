<?php
require_once __DIR__ . '/../models/Direccion.php';

class DireccionController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user_id'] ?? 1; // usa el id del usuario actual
        $ultima = Direccion::ultimaPorUsuario($userId);

        require __DIR__ . '/../views/direcciones/index.php';
    }

    public function guardar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user_id'] ?? 1;
        $ciudad = $_POST['ciudad'] ?? '';
        $departamento = $_POST['departamento'] ?? '';

        if (!empty($ciudad) && !empty($departamento)) {
            Direccion::crear($userId, $ciudad, $departamento);
        }

        // Volver a cargar la vista del formulario (sin redirección a otra página)
        $ultima = Direccion::ultimaPorUsuario($userId);
        require __DIR__ . '/../views/direcciones/index.php';
    }
}
