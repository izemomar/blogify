<?php

namespace App\Repositories;

use App\Models\Api\V1\Article;

class ArticleRepository
{
    public function create(array $data): Article
    {
        $article = Article::create($data);

        return $article;
    }
}
