
<?php // $productos is provided by controller ?>
<h2>Nuestros productos</h2>

<div class="productos-grid">
	<?php foreach ($productos as $p): ?>
		<?php
			$rutaImagen = $p['imagen'];
			// Ajuste si la ruta no tiene "images/" al inicio
			if (!preg_match('/^images\//', $rutaImagen)) {
				$rutaImagen = 'images/' . $rutaImagen;
			}
		?>
		<div class="producto-card">
			<a href="index.php?url=producto/detalle/<?= $p['id'] ?>&keepnav=1">
				<img 
					src="<?= htmlspecialchars($rutaImagen) ?>" 
					alt="<?= htmlspecialchars($p['nombre']) ?>" 
					class="miniatura"
					onerror="this.style.border='2px solid red'; this.alt='Imagen no encontrada'; console.warn('No se encontró la imagen:', this.src);"
					onload="console.log('Imagen cargada correctamente:', this.src);"
				>
			</a>
			<h3><?= htmlspecialchars($p['nombre']) ?></h3>
			<p>$<?= $p['precio'] ?></p>
			
		</div>
	<?php endforeach; ?>
</div>

<style>
.productos-grid {
	display: flex;
	flex-wrap: wrap;
	gap: 16px;
}
.producto-card {
	width: 150px;
	text-align: center;
}
.producto-card img {
	width: 100%;
	height: 100px;
	object-fit: cover;
	border-radius: 8px;
}
</style>
