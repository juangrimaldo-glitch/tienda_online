<?php
require_once __DIR__ . '/../models/Producto.php';

class ProductoController
{
	public function index()
	{
		$productos = Producto::all();
		require_once __DIR__ . '/../views/productos/index.php';
	}

	public function detalle($id = null)
	{
		if ($id === null) {
			header('Location: /public/index.php?url=producto/index');
			exit;
		}
		$producto = Producto::find($id);
		if (!$producto) {
			echo "Producto no encontrado";
			return;
		}
		require_once __DIR__ . '/../views/productos/detalle.php';
	}
}
