<?php if (isset($error)): ?><p style="color:red"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<h2>Login</h2>
<?php $keep = isset($_GET['keepnav']) && $_GET['keepnav'] == '1' ? '&keepnav=1' : '';?>
<form method="post" action="index.php?url=usuarios/login<?= $keep ?>">
    <label>Email: <input type="email" name="email" required></label><br>
    <label>Contraseña: <input type="password" name="password" required></label><br>
    
    <button type="submit">Entrar</button>
</form>
<p>¿No tienes cuenta? <a href="index.php?url=usuarios/registro<?= $keep ?>">Regístrate</a></p>
