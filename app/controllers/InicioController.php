<?php
require_once __DIR__ . '/ProductoController.php';

class InicioController
{
    public function index()
    {
        $pc = new ProductoController();
        $pc->index();
    }
}
