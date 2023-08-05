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

    public function update(int $id, array $data): Article
    {
        $article = $this->getOneById($id);

        $article->update($data);

        return $article;
    }

    public function reloadRelationships(Article $article): Article
    {
        $article->load('metas');
        return $article;
    }

    public function delete(int $id): void
    {
        $article = $this->getOneById($id);

        $article->delete();
    }
}
