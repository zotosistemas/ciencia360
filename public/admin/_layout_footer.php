  </div><!-- /container -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> -->
  <!-- <script src="https://cdn.tiny.cloud/1/qse2dtkj24qu01fhbtz1w6monjrnm612gazlx72l89binxj4/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> -->
  <script src="https://cdn.tiny.cloud/1/<?= $tinyKey ?>/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

  <script>
    function slugify(text) {
      return text
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)+/g, '');
    }

    function debounce(fn, delay = 350) {
      let t;
      return (...args) => {
        clearTimeout(t);
        t = setTimeout(() => fn(...args), delay);
      };
    }
    document.addEventListener('DOMContentLoaded', function() {
      const el = document.getElementById('contenido');
      if (el) {
        tinymce.init({
          selector: '#contenido',
          height: 480,
          menubar: false,
          plugins: 'link image lists table code autoresize',
          toolbar: 'undo redo | styles | bold italic underline | bullist numlist | link image table | code',
          branding: false,
          automatic_uploads: true,
          images_upload_url: 'upload-image.php',
          images_file_types: 'jpg,jpeg,png,webp,gif',
          images_upload_credentials: false,
          paste_data_images: false
        });
      }
      const btnSlug = document.getElementById('btn-genera-slug');
      if (btnSlug) {
        btnSlug.addEventListener('click', function(e) {
          e.preventDefault();
          const title = document.querySelector('input[name="titulo"]');
          const slug = document.querySelector('input[name="slug"]');
          if (title && slug) slug.value = slugify(title.value || '');
          slug.dispatchEvent(new Event('input'));
        });
      }
      const slugInput = document.querySelector('input[name="slug"]');
      const articleId = document.getElementById('article-id');
      const slugStatus = document.getElementById('slug-status');
      const checkSlug = debounce(async function() {
        if (!slugInput) return;
        const slug = slugInput.value.trim();
        if (!slug) {
          slugStatus.innerHTML = '';
          return;
        }
        const params = new URLSearchParams({
          slug
        });
        if (articleId && articleId.value) params.append('excludeId', articleId.value);
        try {
          const res = await fetch('check-slug.php?' + params.toString(), {
            headers: {
              'Accept': 'application/json'
            }
          });
          const data = await res.json();
          if (data.exists) {
            slugStatus.innerHTML = '<span class="text-danger">Slug en uso</span>' + (data.suggestion ? ' — sugerencia: <code>' + data.suggestion + '</code>' : '');
          } else {
            slugStatus.innerHTML = '<span class="text-success">Disponible</span>';
          }
        } catch (e) {
          slugStatus.innerHTML = '<span class="text-muted">No se pudo validar ahora</span>';
        }
      }, 400);
      if (slugInput && slugStatus) {
        slugInput.addEventListener('input', checkSlug);
        if (slugInput.value) checkSlug();
      }
      const fileInput = document.querySelector('input[name="imagen"]');
      if (fileInput) {
        fileInput.addEventListener('change', function() {
          const f = this.files && this.files[0];
          if (!f) return;
          const maxBytes = 3 * 1024 * 1024;
          if (f.size > maxBytes) {
            alert('La imagen supera 3MB.');
            this.value = '';
            return;
          }
          const url = URL.createObjectURL(f);
          const img = new Image();
          img.onload = () => {
            const w = img.naturalWidth,
              h = img.naturalHeight;
            URL.revokeObjectURL(url);
            if (w < 600 || h < 400) {
              alert('Mínimo 600x400 px.');
              fileInput.value = '';
            } else if (w > 4000 || h > 4000) {
              alert('Máx 4000x4000 px.');
              fileInput.value = '';
            }
          };
          img.src = url;
        });
      }
    });
  </script>
  </body>

  </html>