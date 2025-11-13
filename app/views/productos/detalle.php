<?php // $producto es pasado por el controlador ?>

<div class="detalle-producto">
	<div class="col-izq">
		<img 
			src="<?= htmlspecialchars($producto['imagen']) ?>" 
			alt="<?= htmlspecialchars($producto['nombre']) ?>" 
			class="imagen-grande"
			onerror="this.style.border='2px solid red'; this.alt='Imagen no encontrada'; console.warn('No se encontró la imagen:', this.src);"
			onload="console.log('Imagen cargada correctamente:', this.src);"
		>
	</div>

	<div class="col-der">
		<h2><?= htmlspecialchars($producto['nombre']) ?></h2>
		<p class="descripcion"><?= htmlspecialchars($producto['descripcion']) ?></p>
		<p class="precio">$<?= number_format($producto['precio'], 0, ',', '.') ?></p>

		<?php
		require_once __DIR__ . '/../../models/Inventario.php';
		$cantidad = Inventario::getCantidad($producto['id']);
		?>
		<p class="stock">
			<strong>Disponibles:</strong> <?= $cantidad > 0 ? $cantidad : 'Sin stock' ?>
		</p>

		<?php $keep = isset($_GET['keepnav']) && $_GET['keepnav']=='1' ? '&keepnav=1' : ''; ?>
		<form id="add-to-cart-form" action="index.php?url=carrito/add<?= $keep ?>" method="post">
			<input type="hidden" name="product_id" value="<?= $producto['id'] ?>">
			<label>Cantidad: <input type="number" name="cantidad" value="1" min="1"></label>
			<br><br>
			<button type="submit" class="boton">Añadir al carrito</button>
			<span id="cart-confirm" style="display:none;margin-left:10px;color:green;font-weight:bold">Añadido</span>
		</form>

				<!-- 🔽 FORMULARIO DE RESEÑA -->
		<hr style="margin:20px 0;">
		<h3>Deja tu reseña</h3>

		<form action="index.php?url=resena/crear" method="post" class="form-resena">
			<input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">

			<label>Tu nombre:</label><br>
			<input type="text" name="usuario" required><br><br>

			<label>Calificación:</label><br>
			<select name="calificacion" required>
				<option value="5">⭐⭐⭐⭐⭐ </option>
				<option value="4">⭐⭐⭐⭐ </option>
				<option value="3">⭐⭐⭐ </option>
				<option value="2">⭐⭐ </option>
				<option value="1">⭐ </option>
			</select><br><br>

			<label>Comentario:</label><br>
			<textarea name="comentario" rows="3" required></textarea><br><br>

			<button type="submit" class="boton">Enviar reseña</button>
		</form>

		<!-- 🔽 LISTA DE RESEÑAS -->
		<hr style="margin:25px 0;">
		<h3>Reseñas de otros usuarios</h3>
		<?php
		require_once __DIR__ . '/../../models/Resena.php';
		$resenas = Resena::getPorProducto($producto['id']);

		if (count($resenas) === 0) {
			echo "<p>Aún no hay reseñas para este producto.</p>";
		} else {
			foreach ($resenas as $r) {
				echo "<div class='resena'>";
				echo "<strong>" . htmlspecialchars($r['usuario']) . "</strong> ";
				echo "<span>(" . $r['calificacion'] . "⭐)</span><br>";
				echo "<p>" . nl2br(htmlspecialchars($r['comentario'])) . "</p>";
				echo "<small>" . $r['fecha'] . "</small>";
				echo "<hr>";
				echo "</div>";
			}
		}
		?>




	</div>
	
</div>

<style>
.detalle-producto {
	display: flex;
	gap: 20px;
	align-items: flex-start;
}
.col-izq {
	flex: 1;
}
.col-der {
	width: 420px;
}
.imagen-grande {
	width: 100%;
	max-width: 600px;
	object-fit: contain;
	border-radius: 8px;
}
.descripcion {
	margin-top: 15px;
	line-height: 1.5;
	text-align: justify;
}
.precio {
	font-weight: bold;
	font-size: 1.2em;
	margin-top: 10px;
}
.stock {
	margin-top: 8px;
	color: #333;
	font-size: 1em;
}
.stock strong {
	color: #2c6e49;
}
.boton {
	background-color: #2c6e49;
	color: white;
	padding: 10px 18px;
	border: none;
	border-radius: 5px;
	cursor: pointer;
	font-size: 1em;
}
.boton:hover {
	background-color: #245c3d;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function(){
	const form = document.getElementById('add-to-cart-form');
	const confirmEl = document.getElementById('cart-confirm');
	if (!form || !confirmEl) return;

	form.addEventListener('submit', function(){
		confirmEl.style.display = 'inline';
		setTimeout(()=>{ confirmEl.style.display = 'none'; }, 2000);
	});

	// 🔹 Log del producto cargado
	console.log("Vista detalle cargada para producto:", {
		id: "<?= $producto['id'] ?>",
		nombre: "<?= addslashes($producto['nombre']) ?>",
		precio: "<?= $producto['precio'] ?>",
		imagen: "<?= addslashes($producto['imagen']) ?>"
	});
});
</script>
