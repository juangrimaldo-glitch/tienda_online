<?php
require_once __DIR__ . '/../core/Database.php';

class Categoria
{
	public static function all()
	{
		$db = Database::getConnection();
		$result = $db->query("SELECT * FROM categorias");

		$categorias = [];
		while ($fila = $result->fetch_assoc()) {
			$categorias[] = $fila;
		}

		return $categorias;
	}
}
