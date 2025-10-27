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

		<?php $keep = isset($_GET['keepnav']) && $_GET['keepnav']=='1' ? '&keepnav=1' : ''; ?>
		<form id="add-to-cart-form" action="index.php?url=carrito/add<?= $keep ?>" method="post">
			<input type="hidden" name="product_id" value="<?= $producto['id'] ?>">
			<label>Cantidad: <input type="number" name="cantidad" value="1" min="1"></label>
			<br><br>
			<button type="submit" class="boton">Añadir al carrito</button>
			<span id="cart-confirm" style="display:none;margin-left:10px;color:green;font-weight:bold">Añadido</span>
		</form>
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
