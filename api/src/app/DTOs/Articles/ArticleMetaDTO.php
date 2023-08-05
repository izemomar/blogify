<?php

namespace App\DTOs\Articles;

use App\Concerns\ParsableDTO;

class ArticleMetaDTO
{
    use ParsableDTO;

    public readonly string $key;
    public readonly string $value;
    public readonly string $type;

    public function toModel(): array
    {
        return [
            'key' => $this->key,
            'value' => $this->value,
            'type' => $this->type,
        ];
    }
}
