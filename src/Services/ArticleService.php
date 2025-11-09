<?php

namespace Ciencia360\Services;

use Ciencia360\Repositories\ArticleRepository;

class ArticleService
{
    public function __construct(private ArticleRepository $repo) {}

    public function listPaginated(array $filters, int $page = 1, int $perPage = 12): array
    {
        $page = max(1, (int)$page);
        $offset = ($page - 1) * $perPage;

        $items = $this->repo->list($filters, $perPage, $offset);
        $total = $this->repo->count($filters);
        $pages = (int) ceil($total / $perPage);

        return compact('items', 'total', 'pages', 'page', 'perPage');
    }

    public function detailBySlug(string $slug): ?array
    {
        $art = $this->repo->findBySlug($slug);
        if (!$art) return null;
        $this->repo->incrementViews((int)$art['id']);
        $art['relacionados'] = $this->repo->related($art['tema'], $art['slug']);
        return $art;
    }

    public function mostReadByPeriod(string $period = '30d', int $limit = 5): array
    {
        return $this->repo->mostReadByPeriod($period, $limit);
    }
}
