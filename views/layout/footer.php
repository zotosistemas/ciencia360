<footer class="footer-section mt-5">
  <div class="container">
    <!-- Fila principal: copyright + redes -->
    <div class="row align-items-center gy-3">
      <div class="col-md-6 text-center text-md-start">
        © <span id="year"></span> Ciencia360
      </div>
      <div class="col-md-6">
        <div class="footer-social">
          <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
    </div>

    <!-- Fila de enlaces legales -->
    <div class="row mt-2">
      <div class="col">
        <div class="footer-links">
          <a href="politica-privacidad.php">Política de Privacidad</a>
          <span class="dot-separator">•</span>
          <a href="politica-cookies.php">Política de Cookies</a>
          <span class="dot-separator">•</span>
          <a href="contacto.php">Contacto</a>
        </div>
      </div>
    </div>
  </div>
</footer>

<button id="btnScrollTop" class="scroll-top-btn" aria-label="Volver arriba">
  <i class="fas fa-arrow-up"></i>
</button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('year').textContent = new Date().getFullYear();
  document.addEventListener('DOMContentLoaded', () => {
    const collapseEl = document.getElementById('navArticulos');
    if (!collapseEl) return;
    const bsCollapse = bootstrap.Collapse.getOrCreateInstance(collapseEl, {
      toggle: false
    });
    collapseEl.querySelectorAll('a.nav-link, .dropdown-item').forEach(link => {
      link.addEventListener('click', () => bsCollapse.hide());
    });
  });

  // Botón "Ir arriba"
  const btnScrollTop = document.getElementById('btnScrollTop');

  if (btnScrollTop) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 300) {
        btnScrollTop.classList.add('show');
      } else {
        btnScrollTop.classList.remove('show');
      }
    });

    btnScrollTop.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }
</script>
</body>

</html>