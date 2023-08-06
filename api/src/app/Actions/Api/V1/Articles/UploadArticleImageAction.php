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

    public readonly bool $isNew;

    protected string $fileName;

    protected UploadedFile|null $image;

    public function setImage(UploadedFile|null $image): self
    {
        if ($image instanceof UploadedFile) {
            $this->image = $image;
            $this->isNew = true;

            return $this;
        }

        if (is_string($image)) {
            // remove base url from the image
            $image = str_replace(config('app.url').'/images/', '', $image); // articles/*.*
            $originalImageName = str_replace('articles/', '', $image); // *.*

            // check if the image exists in the storage
            if (Storage::disk(self::$storageDisk)->exists($image)) {

                $this->image = new UploadedFile(
                    $image,
                    $originalImageName,
                    Storage::disk(self::$storageDisk)->mimeType($image),
                    null,
                    true
                );
                $this->isNew = false;

                return $this;
            }
        }

        $this->image = null;
        $this->isNew = false;

        return $this;
    }

    /**
     * Generate and set file name with extension
     */
    public function generateAndSetFileName(): static
    {
        if (isset($this->image)) {
            if ($this->isNew) {
                $this->fileName = $this->image->hashName();

                return $this;
            }

            if (is_string($this->image) && ! $this->isNew) {
                $this->fileName = $this->image;

                return $this;
            }
        }

        $this->fileName = self::$defaultImage;

        return $this;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getFilePath(): string
    {
        return self::$storagePath.'/'.$this->fileName;
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

    public static function deleteImage(string $image): bool
    {
        return Storage::disk(self::$storageDisk)->delete($image);
    }

    public function rollback(): bool
    {
        if ($this->getFileName() !== UploadArticleImageAction::$defaultImage) {
            $this->delete();
        }

        return true;
    }
}
