<?php
require_once __DIR__ . '/../models/Rol.php';

class RolController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user']) || $_SESSION['user']['rol_nombre'] !== 'admin') {
            header('Location: index.php?url=usuarios/login');
            exit;
        }

        $roles = Rol::all();
        require_once __DIR__ . '/../views/admin/index.php';
    }
}
