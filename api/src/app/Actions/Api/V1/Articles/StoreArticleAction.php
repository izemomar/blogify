<?php

namespace App\Actions\Api\V1\Articles;

use App\DTOs\Articles\ArticleDTO;
use App\Exceptions\Articles\ArticleCreationException;
use App\Exceptions\Articles\ArticleImageStorageException;
use App\Helpers\ArticleHelper;
use App\Http\Resources\Api\V1\ArticleResource;
use App\Models\Api\V1\Article;
use App\Repositories\ArticleMetaRepository;
use App\Repositories\ArticleRepository;
use App\Validators\Articles\StoreArticleValidator;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class StoreArticleAction
{
    public function __construct(protected ArticleRepository $articleRepository, protected UploadArticleImageAction $uploadArticleImageAction, protected StoreArticleValidator $articleValidator, protected ArticleMetaRepository $articleMetaRepository)
    {
    }

    public function execute(ArticleDTO $articleDTO, bool $autoValidate = false): ArticleResource
    {
        try {

            if ($autoValidate) {
                $this->articleValidator->validate($articleDTO);
            }

            $articleDTO = $this->prepareImageAndUpdateDto($articleDTO);

            $article = $this->articleRepository->create($articleDTO->toModel());

            $this->createDefaultMeta($article, $articleDTO);

            // Upload image
            $this->uploadArticleImageAction->execute();

            $this->articleRepository->reloadRelationships($article);

            return new ArticleResource($article);
        } catch (\Exception $e) {
            $this->uploadArticleImageAction->rollback();

            if (! ($e instanceof ArticleImageStorageException) && ! ($e instanceof ValidationException)) {
                throw new ArticleCreationException(message: $e->getMessage(), previous: $e, details: ['article' => $articleDTO->toModel()]);
            }

            throw $e;
        }
    }

    private function createDefaultMeta(Article $article, ArticleDTO $articleDTO): void
    {
        $meta = ArticleHelper::generateDefaultMeta($articleDTO);
        $this->articleMetaRepository->createMany($article, Arr::map($meta, fn ($item) => $item->toModel()));
    }

    private function prepareImageAndUpdateDto(ArticleDTO $articleDTO): ArticleDTO
    {
        $this->uploadArticleImageAction->setImage($articleDTO->image);
        $this->uploadArticleImageAction->generateAndSetFileName();
        $articleDTO->setImageFileName($this->uploadArticleImageAction->getFilePath());

        return $articleDTO;
    }
}
