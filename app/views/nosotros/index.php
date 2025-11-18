<?php
// Vista 'Nosotros' - información y foto de la dueña con estilo premium
$keepnav = isset($_GET['keepnav']) && $_GET['keepnav'] == '1';
?>

<div class="container py-5 text-light nosotros-page">

    <!-- Hero: Foto de la dueña con overlay -->
    <section class="row g-4 align-items-center mb-5">
        <div class="col-lg-5">
            <div class="card bg-dark border-0 shadow-lg position-relative overflow-hidden nosotros-card">
                <img src="images/foto1.jpg"
                     alt="Dueña del vivero - Amor por las plantas"
                     class="img-fluid object-cover"
                     style="height: 420px; width: 100%; filter: brightness(0.85);">

                <!-- Overlay degradado -->
                <div class="nosotros-overlay"></div>

                <!-- Etiqueta dorada con el nombre -->
                <div class="position-absolute bottom-0 start-0 p-3">
                    <span class="badge text-dark fw-bold px-3 py-2" style="background:#f5d06f;">
                        Carmen Eliza Camayo
                    </span>
                </div>

                <!-- Detalle decorativo en esquina -->
                <div class="position-absolute top-0 end-0 p-3">
                    <span class="pill-glow">🌿</span>
                </div>
            </div>
        </div>

        <!-- Texto principal -->
        <div class="col-lg-7">
            <h2 class="display-6 fw-bold mb-3 title-glow">
                Somos Vivero TiendaOnline
            </h2>

            <p class="lead mb-3">
                Creemos en el pequeño milagro de cada hoja. Nacimos del amor por las plantas y la
                idea de compartir calma, color y vida con nuestros vecinos. Cada maceta guarda una
                historia; cada planta, un abrazo silencioso que alegra la casa.
            </p>

            <p class="mb-3">
                Nuestro motivo es plantar sonrisas: asesoramos con cariño, cuidamos con empeño y
                elegimos especies que llenan de vida tu día a día. Desde la primera semilla hasta la última flor,
                caminamos contigo para que tu hogar sea un pequeño refugio verde.
            </p>

            <blockquote class="blockquote bg-dark bg-opacity-75 border-start border-3 border-warning rounded px-3 py-2 quote-soft">
                “Cultivar es aprender a esperar belleza.”
            </blockquote>

            <!-- Chips de valores -->
            <div class="d-flex flex-wrap gap-2 mt-3">
                <span class="badge rounded-pill text-dark fw-semibold" style="background:#f5d06f;">Asesoría cercana</span>
                <span class="badge rounded-pill text-dark fw-semibold" style="background:#f5d06f;">Cuidado responsable</span>
                <span class="badge rounded-pill text-dark fw-semibold" style="background:#f5d06f;">Selección curada</span>
                <span class="badge rounded-pill text-dark fw-semibold" style="background:#f5d06f;">Espacio para aprender</span>
            </div>

            <!-- CTA -->
            <div class="mt-4">
                <a href="index.php?url=Contacto/index&keepnav=1"
                   class="btn btn-warning fw-bold px-4 py-2 shadow lift-on-hover">
                    🌱 Agenda tu asesoría
                </a>
            </div>
        </div>
    </section>

    <!-- Sección: Lo que te ofrecemos -->
    <section class="bg-dark bg-opacity-75 rounded-4 shadow-lg p-4 p-md-5">
        <h3 class="fw-bold mb-4 section-title">
            Lo que te ofrecemos
        </h3>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 bg-dark border border-warning shadow-sm lift-on-hover">
                    <div class="card-body">
                        <h5 class="card-title text-warning fw-bold">Selección de plantas</h5>
                        <p class="card-text text-light">
                            Especies ideales para tu luz, clima y rutina. Te ayudamos a elegir lo que mejor se adapte a tu espacio.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 bg-dark border border-warning shadow-sm lift-on-hover">
                    <div class="card-body">
                        <h5 class="card-title text-warning fw-bold">Acompañamiento</h5>
                        <p class="card-text text-light">
                            Consejos de riego, sustratos y trasplantes. Queremos que tu planta prospere contigo.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 bg-dark border border-warning shadow-sm lift-on-hover">
                    <div class="card-body">
                        <h5 class="card-title text-warning fw-bold">Detalles únicos</h5>
                        <p class="card-text text-light">
                            Macetas con historia y arreglos que llevan calma a cualquier rincón de tu hogar.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Separador sutil -->
    <div class="divider my-5"></div>
</div>

<style>
    /* Fondo premium */
    body { background: #181616ff !important; }

    /* Títulos y detalles */
    .title-glow { color:#f5d06f; text-shadow:0 0 8px rgba(0,0,0,0.8); }
    .section-title { color:#f5d06f; text-shadow:0 0 6px black; }

    /* Tarjeta principal (foto dueña) */
    .object-cover { object-fit: cover; }
    .nosotros-card { border-radius: 1rem; }
    .nosotros-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(180deg, rgba(0,0,0,0.0) 40%, rgba(0,0,0,0.6) 100%);
    }

    /* Detalle decorativo */
    .pill-glow {
        display:inline-block; padding:.35rem .6rem; border-radius: 999px;
        background: rgba(245,208,111,.15); color:#f5d06f; backdrop-filter: blur(3px);
        box-shadow: 0 0 12px rgba(245,208,111,.35);
        animation: softPulse 3s ease-in-out infinite;
    }

    /* Botón con efecto lift */
    .lift-on-hover { transition: transform .25s ease, box-shadow .25s ease; }
    .lift-on-hover:hover { transform: translateY(-4px); box-shadow: 0 0 18px rgba(245,208,111,.45) !important; }

    /* Divider sutil */
    .divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(245,208,111,.6), transparent);
    }

    /* Cita suave */
    .quote-soft { border-radius:.6rem; }

    /* Animación pulso suave */
    @keyframes softPulse {
        0% { transform: scale(1); box-shadow: 0 0 10px rgba(245,208,111,.25); }
        50% { transform: scale(1.05); box-shadow: 0 0 16px rgba(245,208,111,.45); }
        100% { transform: scale(1); box-shadow: 0 0 10px rgba(245,208,111,.25); }
    }
</style>
