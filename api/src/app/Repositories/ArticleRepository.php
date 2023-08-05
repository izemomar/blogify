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

    /**
     * @param int $id
     * @return Article
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getOneById(int $id): Article
    {
        $article = Article::findOrFail($id)->load('metas');
        return $article;
    }
}
