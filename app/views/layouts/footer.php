    </main>

    <footer class="footer-premium text-center py-3 mt-4 animate__animated animate__fadeInUp">
        <p class="mb-0">
            &copy; <?php echo date("Y"); ?> 
            <span class="footer-brand">Tienda Online</span> - Todos los derechos reservados.
        </p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<style>
    /* =======================
       Footer estilo premium
    ======================= */
    .footer-premium {
        background: rgba(0, 0, 0, 0.85);
        backdrop-filter: blur(6px);
        color: #f5d06f;
        font-weight: 500;
        letter-spacing: 1px;
    }
    .footer-premium p {
        margin: 0;
        color: #f5d06f;
    }
    .footer-brand {
        font-weight: 700;
        color: #ffffff;
        text-shadow: 0 0 6px black;
    }
</style>
