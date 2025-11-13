<?php
$keepnav = isset($_GET['keepnav']) && $_GET['keepnav'] == '1';
?>


<h2>Mi Direccion</h2>

<form method="POST" action="index.php?url=Direccion/guardar">
    <label>Ciudad:</label><br>
    <input type="text" name="ciudad" required><br><br>

    <label>Departamento:</label><br>
    <input type="text" name="departamento" required><br><br>

    <button type="submit">Guardar dirección</button>
</form>

<hr>

<?php if (!empty($ultima)): ?>
    <h3>Última dirección guardada</h3>
    <p><strong>Ciudad:</strong> <?= htmlspecialchars($ultima['ciudad']) ?></p>
    <p><strong>Departamento:</strong> <?= htmlspecialchars($ultima['departamento']) ?></p>
<?php else: ?>
    <p>No hay direcciones registradas todavía.</p>
<?php endif; ?>
