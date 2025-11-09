CREATE TABLE IF NOT EXISTS articulos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(200) UNIQUE NOT NULL,
  titulo VARCHAR(255) NOT NULL,
  resumen TEXT NULL,
  contenido LONGTEXT NULL,
  imagen VARCHAR(255) NULL,
  tema ENUM('ciencia-tecnologia','medio-ambiente','salud-biologia','espacio-futuro') NOT NULL,
  autor VARCHAR(120) NULL,
  fecha_publicacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  visitas INT NOT NULL DEFAULT 0,
  INDEX idx_tema (tema),
  INDEX idx_fecha (fecha_publicacion),
  INDEX idx_visitas (visitas)
);

-- Ampliación de la tabla artículos para el panel admin
ALTER TABLE articulos
  ADD COLUMN IF NOT EXISTS estado ENUM('borrador','publicado') NOT NULL DEFAULT 'publicado',
  ADD COLUMN IF NOT EXISTS tipo   ENUM('articulo','infografia','video') NOT NULL DEFAULT 'articulo',
  ADD COLUMN IF NOT EXISTS created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  ADD COLUMN IF NOT EXISTS updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Índice único para slug (ejecutar una sola vez; si hay duplicados, corrígelos antes)
ALTER TABLE articulos
  ADD UNIQUE KEY slug_unique (slug);


-- Crear tabla granular de vistas
CREATE TABLE IF NOT EXISTS article_views (
  id INT AUTO_INCREMENT PRIMARY KEY,
  article_id INT NOT NULL,
  viewed_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  ip VARBINARY(16) NULL,
  user_agent VARCHAR(255) NULL,
  KEY idx_article_time (article_id, viewed_at),
  KEY idx_time (viewed_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
