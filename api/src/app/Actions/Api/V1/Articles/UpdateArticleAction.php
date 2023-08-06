<?php

namespace App\Actions\Api\V1\Articles;

use App\DTOs\Articles\ArticleDTO;
use App\Helpers\ArticleHelper;
use App\Http\Resources\Api\V1\ArticleResource;
use App\Models\Api\V1\Article;
use App\Repositories\ArticleMetaRepository;
use App\Repositories\ArticleRepository;
use App\Validators\Articles\UpdateArticleValidator;
use Illuminate\Support\Arr;

class UpdateArticleAction
{
    public function __construct(
        protected ArticleRepository $articleRepository,
        protected UpdateArticleValidator $validator,
        protected ArticleMetaRepository $articleMetaRepository,
        protected UploadArticleImageAction $uploadArticleImageAction
    ) {
    }

    /**
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function execute(int $id, ArticleDTO $dto, bool $autoValidate = false): ArticleResource
    {
        try {
            if ($autoValidate) {
                $this->validator->validate($dto);
            }

            $dto = $this->prepareImageAndUpdateDto($dto);

            $article = $this->articleRepository->update($id, $dto->toModel());

            $this->updateOrCreateMeta($article, $dto);

            // Upload image
            if ($this->uploadArticleImageAction->isNew) {
                $this->uploadArticleImageAction->execute();
            }

            $this->articleRepository->reloadRelationships($article);

            return new ArticleResource($article);
        } catch (\Exception $e) {
            if ($this->uploadArticleImageAction->getFileName() !== UploadArticleImageAction::$defaultImage && $this->uploadArticleImageAction->isNew) {
                $this->uploadArticleImageAction->delete();
            }

            throw $e;
        }
    }

    private function updateOrCreateMeta(Article $article, ArticleDTO $articleDTO): void
    {
        $meta = ArticleHelper::generateDefaultMeta($articleDTO);
        $this->articleMetaRepository->upsertMany($article, Arr::map($meta, fn ($item) => $item->toModel()));
    }

    private function prepareImageAndUpdateDto(ArticleDTO $articleDTO): ArticleDTO
    {
        $this->uploadArticleImageAction->setImage($articleDTO->image);
        $this->uploadArticleImageAction->generateAndSetFileName();
        $articleDTO->setImageFileName($this->uploadArticleImageAction->getFilePath());

        return $articleDTO;
    }
}
