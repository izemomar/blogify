<?php

namespace App\Actions\Api\V1\Articles;

use App\Exceptions\Articles\ArticleImageStorageException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadArticleImageAction
{
    public static string $storagePath = 'articles';

    public static string $storageDisk = 'public';

    public static string $defaultImage = 'articles/no-image.png';

    protected string $fileName;

    protected UploadedFile|null $image;

    public function setImage(UploadedFile|null $image): self
    {
        if ($image instanceof UploadedFile) {
            $this->image = $image;
        } else {
            $this->image = null;
        }

        return $this;
    }

    /**
     * Generate and set file name with extension
     */
    public function generateAndSetFileName(): static
    {
        if (isset($this->image)) {
            $this->fileName = $this->image->hashName();
        }

        return $this;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getFilePath(): string
    {
        return self::$storagePath . '/' . $this->fileName;
    }

    /**
     * @param  \Illuminate\Http\UploadedFile|null  $image
     */
    private function upload(UploadedFile $image): string
    {
        return $image->store('articles', 'public');
    }

    /**
     * @param  \Illuminate\Http\UploadedFile|null  $image
     */
    public function execute(): string
    {
        try {
            if (isset($this->image)) {
                if (empty($this->fileName)) {
                    $this->generateAndSetFileName();
                }

                return $this->upload($this->image);
            }

            return self::$defaultImage;
        } catch (\Exception $e) {
            throw new ArticleImageStorageException();
        }
    }

    public function delete(): bool
    {
        return Storage::disk(self::$storageDisk)->delete($this->getFilePath());
    }
}
