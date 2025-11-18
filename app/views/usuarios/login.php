<?php $keep = isset($_GET['keepnav']) && $_GET['keepnav'] == '1' ? '&keepnav=1' : ''; ?>

<style>
    body {
        background-color: #000; 
        min-height: 100vh;
        color: #f5d06f; /* texto dorado */
    }
    .text-gold {
        color: #f5d06f;
    }
</style>

<div class="container d-flex justify-content-center align-items-center py-5 text-gold" style="min-height:85vh;">
    <div class="card bg-dark p-4 rounded shadow-lg text-gold" style="max-width: 380px; width:100%; border:1px solid #f5d06f40;">
        
        <h2 class="text-center mb-3 text-gold">Iniciar Sesión</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" action="index.php?url=usuarios/login<?= $keep ?>">
            <div class="mb-3">
                <label class="form-label text-gold">Email:</label>
                <input type="email" name="email" class="form-control bg-dark text-light border-warning" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-gold">Contraseña:</label>
                <input type="password" name="password" class="form-control bg-dark text-light border-warning" required>
            </div>

            <button type="submit" class="btn btn-warning fw-bold w-100">Entrar</button>
        </form>

        <p class="text-center mt-3">
            ¿No tienes cuenta?<br>
            <a href="index.php?url=usuarios/registro<?= $keep ?>" class="fw-bold text-gold">Registrarte</a>
        </p>
    </div>
</div>
