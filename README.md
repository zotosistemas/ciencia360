# 🧠 Ciencia360 - Portal de Divulgación Científica

Proyecto PHP moderno para gestionar y publicar artículos científicos con un panel administrativo seguro.  
Incluye integración con **Google AdSense**, editor visual **TinyMCE**, sistema de vistas **populares**, y buenas prácticas de seguridad (CSRF, sesiones seguras, hash de contraseña, etc.).

## 🚀 1. Requisitos Previos

- PHP 8.1+
- Composer
- MySQL / MariaDB
- Servidor local (XAMPP, Laragon, etc.)
- Extensiones PHP requeridas: `pdo_mysql`, `openssl`, `mbstring`

## 📦 2. Instalación del Proyecto

1. Clona o copia el proyecto
   ```bash
   git clone https://github.com/tuusuario/ciencia360.git
   cd ciencia360
   ```

2. Instala dependencias
   ```bash
   composer install
   ```

3. Copia el archivo de entorno
   ```bash
   cp config/.env.example config/.env
   ```
   Luego edítalo con tus credenciales de base de datos y configuración de AdSense:
   ```env
   DB_HOST=localhost
   DB_NAME=ciencia360
   DB_USER=root
   DB_PASS=

   ADSENSE_CLIENT=ca-pub-XXXXXXXXXXXXXXXX
   ADMIN_USER=admin
   ADMIN_PASS_HASH=
   ```

## 🧰 3. Estructura del Proyecto

```
ciencia360/
├── config/
│   └── .env
├── public/
│   ├── admin/
│   ├── articulo.php
│   ├── articulos.php
│   └── index.php
├── src/
│   ├── Config/
│   ├── Helpers/
│   ├── Http/
│   ├── Repositories/
│   ├── Services/
│   └── Support/
├── storage/cache/
└── vendor/
```

## 🔐 4. Seguridad del Panel Administrativo

Incluye:
- Cookies seguras (`HttpOnly`, `SameSite=Lax`)
- Tokens CSRF
- Hash de contraseña con `password_hash`
- Regeneración de sesión tras login

## ⚙️ 5. Configuración de Contraseña Hash

1. Generar hash:
   ```bash
   php -r "echo password_hash('TuContraSegura#2025', PASSWORD_DEFAULT);"
   ```

2. Pegar en `.env`:
   ```env
   ADMIN_PASS_HASH=$2y$10$EXAMPLEEXAMPLEEXAMPLEEXAMPLE
   ```

3. Validación en login:
   ```php
   if (password_verify($p, Config::get('ADMIN_PASS_HASH'))) {
       session_regenerate_id(true);
       $_SESSION['admin_logged'] = true;
   }
   ```

## 🧾 6. Base de Datos

### Tabla `articulos`
```sql
CREATE TABLE articulos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  slug VARCHAR(255) UNIQUE NOT NULL,
  resumen TEXT,
  contenido LONGTEXT,
  tema VARCHAR(100),
  imagen VARCHAR(255),
  fecha_publicacion DATETIME DEFAULT CURRENT_TIMESTAMP,
  visitas INT DEFAULT 0,
  estado ENUM('borrador','publicado') DEFAULT 'publicado'
);
```

### Tabla `article_views`
```sql
CREATE TABLE article_views (
  id INT AUTO_INCREMENT PRIMARY KEY,
  article_id INT NOT NULL,
  viewed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (article_id) REFERENCES articulos(id)
);
```

## 📊 7. Integración con AdSense

Bloques configurados en `articulo.php`:
```html
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-XXXXXXXXXXXX"
     data-ad-slot="1234567890"
     data-adtest="on"
     data-ad-format="auto"></ins>
<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
```

## 🌍 8. Producción

- Habilitar HTTPS y `secure=true` en cookies
- Desactivar `display_errors`
- Asignar permisos 755 (carpetas) y 644 (archivos)
- No exponer `.env` ni `.sql`

---
© Ciencia360 | Desarrollado por Juan Carlos Soto Castañeda
