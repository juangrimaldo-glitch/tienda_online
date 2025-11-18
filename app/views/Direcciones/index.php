<div class="container py-5 text-light">

    <h2 class="text-center fw-bold mb-4" style="color:#f5d06f; text-shadow:0 0 6px black;">
        Mi Dirección
    </h2>

    <form method="POST" action="index.php?url=Direccion/guardar"
          class="bg-dark p-4 rounded shadow mx-auto" style="max-width:500px;">

        <div class="mb-3">
            <label class="form-label" style="color:#f5d06f;">Ciudad</label>
            <input type="text" name="ciudad" class="form-control bg-dark text-light border-warning" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="color:#f5d06f;">Departamento</label>
            <input type="text" name="departamento" class="form-control bg-dark text-light border-warning" required>
        </div>

        <button class="btn btn-warning fw-semibold w-100">Guardar dirección</button>
    </form>

    <hr class="my-4 border-warning">

    <?php if (!empty($ultima)): ?>
        <h4 class="text-center mb-3" style="color:#f5d06f;">Última dirección guardada</h4>
        <div class="bg-dark p-3 rounded shadow mx-auto" style="max-width:500px;">
            <p><strong style="color:#f5d06f;">Ciudad:</strong> <?= htmlspecialchars($ultima['ciudad']) ?></p>
            <p><strong style="color:#f5d06f;">Departamento:</strong> <?= htmlspecialchars($ultima['departamento']) ?></p>
        </div>
    <?php else: ?>
        <p class="text-center">No hay direcciones registradas todavía.</p>
    <?php endif; ?>

</div>

<style>
    body { background:#111 !important; }
</style>
