<?php

namespace App\Repositories;

use App\DTOs\Articles\ArticlePaginationDTO;
use App\Models\Api\V1\Article;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleRepository
{
    public function create(array $data): Article
    {
        $article = Article::create($data);

        return $article;
    }

    /**
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

    public function paginate(ArticlePaginationDTO $dto): LengthAwarePaginator
    {
        $articles = Article::query();

        if (count($dto->include) > 0) {
            $articles->with($dto->include);
        }

        if (isset($dto->search)) {
            $articles->where('title', 'like', "%{$dto->search}%");
        }

        if (isset($dto->status)) {
            $articles->where('status', $dto->status);
        }

        if (isset($dto->orderBy)) {
            $articles->orderBy($dto->orderBy, $dto->orderDirection);
        }

        return $articles->paginate($dto->perPage, ['*'], 'page', $dto->page);
    }
}
