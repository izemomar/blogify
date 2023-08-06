<?php

namespace App\Observers\Api\V1;

use App\Enums\ArticleStatusEnum;
use App\Helpers\ArticleHelper;
use App\Models\Api\V1\Article;

class ArticleObserver
{
    private function handleStatusChange(Article $article): void
    {
        if (! $article->isDirty('status')) {
            return;
        }
        if ($article->status !== ArticleStatusEnum::PUBLISHED) {
            return;
        }

        $article->published_at = now();
    }

    private function setSlug(Article $article): void
    {
        if (! $article->isDirty('title')) {
            return;
        }
        $article->slug = ArticleHelper::generateSlug($article->title);
    }

    public function creating(Article $article): void
    {
        $this->handleStatusChange($article);
        $this->setSlug($article);
    }

    public function updating(Article $article): void
    {
        $this->handleStatusChange($article);
        $this->setSlug($article);
    }
}
