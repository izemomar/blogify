<?php

namespace App\Helpers;

use App\DTOs\Articles\ArticleDTO;
use App\DTOs\Articles\ArticleMetaDTO;

class ArticleHelper
{
    public static function countWords(string $content): int
    {
        $content = strip_tags($content);
        $content = preg_replace('/\s+/', ' ', $content);
        $content = trim($content);
        $words = explode(' ', $content);

        return count($words);
    }

    public static function countMinutesToRead(string $content): int
    {
        $words = self::countWords($content);
        $minutes = ceil($words / 200);

        return $minutes;
    }

    /**
     * Generate default meta for an article.
     * 
     * @param ArticleDTO $articleDTO
     * 
     * @return App\DTOs\Articles\ArticleMetaDTO[]
     */
    public static function generateDefaultMeta(ArticleDTO $articleDTO): array
    {
        $meta = [];

        $meta[] = ArticleMetaDTO::fromArray([
            'key' => 'count_words',
            'value' => self::countWords($articleDTO->content),
            'type' => 'number'
        ]);

        $meta[] = ArticleMetaDTO::fromArray([
            'key' => 'minutes_to_read',
            'value' => self::countMinutesToRead($articleDTO->content),
            'type' => 'number'
        ]);

        return $meta;
    }

    public static function generateSlug(string $title): string
    {
        $slug = strtolower($title);
        $slug = preg_replace('/[^a-z0-9\s]/', '', $slug);
        $slug = preg_replace('/\s+/', '-', $slug);
        $slug = trim($slug, '-');

        return $slug;
    }
}
