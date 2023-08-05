<?php

namespace App\Repositories;

use App\Models\Api\V1\Article;

class ArticleMetaRepository
{
    public function createMany(Article $article, array $data): void
    {
        $article->metas()->createMany($data);
    }
}
