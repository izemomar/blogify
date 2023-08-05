<?php

namespace App\Actions\Api\V1\Articles;

use App\Repositories\ArticleMetaRepository;
use App\Repositories\ArticleRepository;

class DeleteArticleAction
{
    public function __construct(protected ArticleRepository $articleRepository, protected ArticleMetaRepository $articleMetaRepository)
    {
    }

    public function execute(int $id): void
    {
        $article = $this->articleRepository->getOneById($id);
        $image = $article->image;
        $this->articleMetaRepository->deleteMany($article);
        $this->articleRepository->delete($id);

        if ($image !== UploadArticleImageAction::$defaultImage) {
            UploadArticleImageAction::deleteImage($image);
        }
    }
}
