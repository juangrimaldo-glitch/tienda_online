<?php
$keepnav = isset($_GET['keepnav']) && $_GET['keepnav'] == '1';
?>

<h2>Contáctanos</h2>
<form method="POST" action="index.php?url=contacto/enviar">
	<label>Nombre:</label><br>
	<input type="text" name="nombre" required><br>

	<label>Email:</label><br>
	<input type="email" name="email" required><br>

	<label>Teléfono:</label><br>
	<input type="text" name="telefono"><br>

	<label>Mensaje:</label><br>
	<textarea name="mensaje" required></textarea><br>

	<button type="submit" class="boton">Enviar</button>
</form>
