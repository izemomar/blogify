<?php

namespace App\Actions\Api\V1\Articles;

use App\DTOs\Articles\ArticlePaginationDTO;

use App\Repositories\ArticleRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateArticlesAction
{

    public function __construct(
        protected ArticleRepository $articleRepository
    ) {
    }


    public function execute(ArticlePaginationDTO $dto): LengthAwarePaginator
    {
        $articles = $this->articleRepository->paginate($dto);

        return $articles;
    }
}
