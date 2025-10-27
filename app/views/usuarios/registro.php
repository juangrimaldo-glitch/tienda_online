<?php if (isset($error)): ?><p style="color:red"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<h2>Registro</h2>
<?php $keep = isset($_GET['keepnav']) && $_GET['keepnav'] == '1' ? '&keepnav=1' : '';?>
<form method="post" action="index.php?url=usuarios/registro<?= $keep ?>">
    <label>Usuario: <input type="text" name="username" required></label><br>
    <label>Email: <input type="email" name="email" required></label><br>
    <label>Contraseña: <input type="password" name="password" required></label><br>
    <button type="submit">Crear cuenta</button>
</form>
<p>¿Ya tienes cuenta? <a href="index.php?url=usuarios/login<?= $keep ?>">Ingresa</a></p>
