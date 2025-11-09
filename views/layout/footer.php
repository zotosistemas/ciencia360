<footer class="footer-section mt-5">
  <div class="container">
    <div class="row align-items-center gy-3">
      <div class="col-md-6 text-center text-md-start">© <span id="year"></span> Ciencia360</div>
      <div class="col-md-6">
        <div class="footer-social">
          <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('year').textContent = new Date().getFullYear();
  document.addEventListener('DOMContentLoaded', () => {
    const collapseEl = document.getElementById('navArticulos');
    if (!collapseEl) return;
    const bsCollapse = bootstrap.Collapse.getOrCreateInstance(collapseEl, { toggle: false });
    collapseEl.querySelectorAll('a.nav-link, .dropdown-item').forEach(link => {
      link.addEventListener('click', () => bsCollapse.hide());
    });
  });
</script>
</body>
</html>
