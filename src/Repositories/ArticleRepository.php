<?php

namespace Ciencia360\Repositories;

use Ciencia360\Config\Database;

class ArticleRepository
{
    public function list(array $filters, int $limit, int $offset): array
    {
        $pdo = Database::pdo();
        $sql = "SELECT * FROM articulos WHERE 1=1";
        $params = [];

        if (!empty($filters['tema'])) {
            $sql .= " AND tema = ?";
            $params[] = $filters['tema'];
        }
        if (!empty($filters['q'])) {
            $sql .= " AND titulo LIKE ?";
            $params[] = "%" . $filters['q'] . "%";
        }

        $sql .= ($filters['orden'] ?? 'recientes') === 'populares'
            ? " ORDER BY visitas DESC, fecha_publicacion DESC"
            : " ORDER BY fecha_publicacion DESC";

        $sql .= " LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;

        $st = $pdo->prepare($sql);
        $st->execute($params);
        return $st->fetchAll();
    }

    public function count(array $filters): int
    {
        $pdo = Database::pdo();
        $sql = "SELECT COUNT(*) FROM articulos WHERE 1=1";
        $params = [];

        if (!empty($filters['tema'])) {
            $sql .= " AND tema = ?";
            $params[] = $filters['tema'];
        }
        if (!empty($filters['q'])) {
            $sql .= " AND titulo LIKE ?";
            $params[] = "%" . $filters['q'] . "%";
        }

        $st = $pdo->prepare($sql);
        $st->execute($params);
        return (int) $st->fetchColumn();
    }

    public function findBySlug(string $slug): ?array
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare("SELECT * FROM articulos WHERE slug = ? LIMIT 1");
        $st->execute([$slug]);
        $row = $st->fetch();
        return $row ?: null;
    }

    public function incrementViews(int $id): void
    {
        $pdo = Database::pdo();
        $pdo->prepare("UPDATE articulos SET visitas = visitas + 1 WHERE id = ?")->execute([$id]);
    }

    public function related(string $tema, string $excludeSlug, int $limit = 3): array
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare("SELECT slug, titulo, imagen FROM articulos
                             WHERE tema = ? AND slug <> ?
                             ORDER BY fecha_publicacion DESC LIMIT ?");
        $st->execute([$tema, $excludeSlug, $limit]);
        return $st->fetchAll();
    }

    public function mostReadByPeriod(string $period = '30d', int $limit = 5): array
    {
        $pdo = Database::pdo();
        $limit = max(1, min($limit, 20));

        switch ($period) {
            case 'today':
                $interval = 'INTERVAL 1 DAY';
                break;
            case '7d':
                $interval = 'INTERVAL 7 DAY';
                break;
            case '30d':
                $interval = 'INTERVAL 30 DAY';
                break;
            case '90d':
                $interval = 'INTERVAL 90 DAY';
                break;
            default:
                $interval = 'INTERVAL 30 DAY';
        }

        // Interpolamos $interval y $limit (valores saneados) porque MySQL no admite bind param en INTERVAL
        // y LIMIT no siempre se puede bindear si no usas emulación de prepares.
        $sql = "
        SELECT a.id, a.slug, a.titulo, COUNT(v.id) AS views
        FROM articulos a
        LEFT JOIN article_views v
            ON v.article_id = a.id
        AND v.viewed_at >= (NOW() - {$interval})
        WHERE a.estado = 'publicado'
        GROUP BY a.id, a.slug, a.titulo
        ORDER BY views DESC, a.updated_at DESC
        LIMIT {$limit}";

        return $pdo->query($sql)->fetchAll(); // <- aquí el fix
    }
}
