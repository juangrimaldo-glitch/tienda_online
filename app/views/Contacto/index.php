<div class="container py-5 text-light">

    <h2 class="text-center fw-bold mb-4" style="color:#f5d06f; text-shadow:0 0 6px black;">
        Contáctanos
    </h2>

    <form method="POST" action="index.php?url=contacto/enviar"
          class="bg-dark p-4 rounded shadow mx-auto" style="max-width:500px;">

        <div class="mb-3">
            <label class="form-label" style="color:#f5d06f;">Nombre</label>
            <input type="text" name="nombre" class="form-control bg-dark text-light border-warning" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="color:#f5d06f;">Email</label>
            <input type="email" name="email" class="form-control bg-dark text-light border-warning" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="color:#f5d06f;">Teléfono</label>
            <input type="text" name="telefono" class="form-control bg-dark text-light border-warning">
        </div>

        <div class="mb-3">
            <label class="form-label" style="color:#f5d06f;">Mensaje</label>
            <textarea name="mensaje" class="form-control bg-dark text-light border-warning" rows="4" required></textarea>
        </div>

        <button class="btn btn-warning fw-semibold w-100">Enviar</button>
    </form>

</div>

<style>
    body { background:#111 !important; }
</style>
