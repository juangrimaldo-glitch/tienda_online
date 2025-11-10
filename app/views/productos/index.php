<?php // $productos y $categorias son provistos por el controlador ?> 

<h2>Nuestros productos</h2>

<!-- 🔹 Filtro por categoría -->
<form method="get" action="index.php" class="filtro-categorias">
	<input type="hidden" name="url" value="producto/index">
	<label for="categoria">Filtrar por categoría:</label>
	<select name="categoria" id="categoria" onchange="this.form.submit()">
		<option value="">Todas</option>
		<?php foreach ($categorias as $c): ?>
			<option value="<?= $c['id'] ?>" 
				<?= (isset($_GET['categoria']) && $_GET['categoria'] == $c['id']) ? 'selected' : '' ?>>
				<?= htmlspecialchars($c['nombre']) ?>
			</option>
		<?php endforeach; ?>
	</select>
</form>

<div class="productos-grid">
	<?php foreach ($productos as $p): ?>
		<?php
			$rutaImagen = $p['imagen'];
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
					onerror="this.style.border='2px solid red'; this.alt='Imagen no encontrada';"
				>
			</a>
			<h3><?= htmlspecialchars($p['nombre']) ?></h3>
			<p>$<?= $p['precio'] ?></p>
		</div>
	<?php endforeach; ?>
</div>

<style>
.filtro-categorias {
	margin-bottom: 20px;
}
.filtro-categorias select {
	padding: 6px 10px;
	border-radius: 6px;
}
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
