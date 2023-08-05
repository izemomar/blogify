<?php

namespace App\DTOs\Articles;

use App\Concerns\ParsableDTO;
use App\Enums\ArticleStatusEnum;
use Illuminate\Http\UploadedFile;

class ArticleDTO
{
    use ParsableDTO;

    public readonly string $title;

    public readonly string $slug;

    public readonly string $summary;

    public readonly string $content;

    public readonly ArticleStatusEnum|string $status;

    /**
     * To store the incoming image file from the request.
     *
     * @var UploadedFile|null
     */
    public readonly ?UploadedFile $image;

    /**
     * To store the image file name.
     */
    public readonly ?string $imageFileName;

    public function setImageFileName(?string $imageFileName): self
    {
        $this->imageFileName = $imageFileName;
        return $this;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function toModel(): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'content' => $this->content,
            'status' => $this->status,
            'image' => $this->imageFileName,
        ];
    }
}
