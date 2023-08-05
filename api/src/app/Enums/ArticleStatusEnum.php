<?php

namespace App\Enums;

enum ArticleStatusEnum: string
{
    const DRAFT = 'draft';

    const PUBLISHED = 'published';

    const ARCHIVED = 'archived';

    public static function getValues(): array
    {
        return [
            self::DRAFT,
            self::PUBLISHED,
            self::ARCHIVED,
        ];
    }
}
