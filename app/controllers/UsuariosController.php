<?php
// Controlador plural que delega en UsuarioController para mantener compatibilidad con rutas 'usuarios/...'
require_once __DIR__ . '/UsuarioController.php';

class UsuariosController extends UsuarioController
{
    // Hereda todas las acciones de UsuarioController
}
