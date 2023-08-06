<?php

namespace App\DTOs\Articles;

use App\Concerns\ParsableDTO;
use App\Enums\ArticleStatusEnum;
use Illuminate\Http\UploadedFile;

class ArticleDTO
{
    use ParsableDTO;

    public string $title;

    public string $slug;

    public string $summary;

    public string $content;

    public ArticleStatusEnum|string $status;

    /**
     * To store the incoming image file from the request.
     */
    public UploadedFile|string|null $image;

    /**
     * To store the image file name.
     */
    public ?string $imageFileName;

    public function __construct()
    {
        $this->status = ArticleStatusEnum::DRAFT;
        $this->image = null;
        $this->imageFileName = null;
    }

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
