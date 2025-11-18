<style>
    body {
        background-color: #000;
        min-height: 100vh;
    }
</style>

<div class="container d-flex justify-content-center align-items-center py-5" style="min-height:85vh;">
    <div class="card bg-dark rounded shadow-lg p-4 text-warning text-center" 
         style="max-width: 450px; width:100%; border:1px solid #f5d06f40;">
        
        <h2 class="mb-3" style="color:#f5d06f;">Mi Perfil</h2>

        <p><strong>Usuario:</strong> <?= htmlspecialchars($user['username']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>

        <a href="index.php?url=usuarios/logout" class="btn btn-danger w-100 fw-bold mt-3">Cerrar Sesión</a>
    </div>
</div>
