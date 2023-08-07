<?php

namespace App\DTOs\Articles;

/**
 * Class PaginationDTO
 * Data transfer object for pagination data
 */
class ArticlePaginationDTO
{
    public static int $maxPerPage = 100;

    public static $defaultPerPage = 10;

    public function __construct(
        public readonly int $page = 1,
        public readonly int $perPage = 10,
        public readonly string $orderBy = 'id',
        public readonly string $orderDirection = 'asc',
        public readonly string $search = '',
        public readonly string|null $status = null,
        public readonly array $include = [],
    ) {
    }

    public static function fromRequest(array $data): static
    {
        return new static(
            page: $data['page'] ?? 1,
            perPage: $data['perPage'] ?? static::$defaultPerPage,
            orderBy: $data['orderBy'] ?? 'created_at',
            orderDirection: $data['dir'] ?? 'asc',
            search: $data['search'] ?? '',
            status: $data['status'] ?? null,
            include: $data['include'] ?? [],
        );
    }
}
