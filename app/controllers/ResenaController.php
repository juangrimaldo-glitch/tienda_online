<?php
require_once __DIR__ . '/../models/Resena.php';

class ResenaController
{
    public function crear()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productoId = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;
            $usuario = trim($_POST['usuario'] ?? '');
            $comentario = trim($_POST['comentario'] ?? '');
            $calificacion = intval($_POST['calificacion'] ?? 0);

            if ($productoId > 0 && $usuario !== '' && $comentario !== '' && $calificacion > 0) {
                Resena::crear($productoId, $usuario, $comentario, $calificacion);
            }

            // 🔹 Redirige al mismo producto, SIN cambiar de vista
            header('Location: index.php?url=producto/detalle/' . $productoId);
            exit;
        }
    }
}
?>

