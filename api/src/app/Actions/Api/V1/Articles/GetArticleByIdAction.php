<?php

namespace App\Actions\Api\V1\Articles;

use App\Http\Resources\Api\V1\ArticleResource;
use App\Repositories\ArticleRepository;

class GetArticleByIdAction
{

    public function __construct(
        protected ArticleRepository $articleRepository
    ) {
    }

    /**
     * @param int $id
     * 
     * @return ArticleResource
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function execute(int $id): ArticleResource
    {
        $article = $this->articleRepository->getOneById($id);
        return new ArticleResource($article);
    }
}
