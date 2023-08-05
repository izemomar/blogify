<?php

namespace App\Actions\Api\V1\Articles;

use App\DTOs\Articles\ArticleDTO;
use App\Helpers\ArticleHelper;
use App\Http\Resources\Api\V1\ArticleResource;
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
     * @param int $id
     * 
     * @return ArticleResource
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function execute(int $id, ArticleDTO $dto, bool $autoValidate = false): ArticleResource
    {
        try {
            if ($autoValidate) {
                $this->validator->validate($dto);
            }

            $this->uploadArticleImageAction->setImage($dto->image);
            $this->uploadArticleImageAction->generateAndSetFileName();
            $dto->setImageFileName($this->uploadArticleImageAction->getFilePath());

            $dto->setSlug(ArticleHelper::generateSlug($dto->title));

            $article = $this->articleRepository->update($id, $dto->toModel());

            // Create article metas
            $meta = ArticleHelper::generateDefaultMeta($dto);
            $this->articleMetaRepository->upsertMany($article, Arr::map($meta, fn ($item) => $item->toModel()));

            // Upload image
            if ($this->uploadArticleImageAction->isNew) {
                $this->uploadArticleImageAction->delete();
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
}
