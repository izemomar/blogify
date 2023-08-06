<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ArticleResource extends JsonResource
{
    private function imageUrl(): string|null
    {
        if (! is_null($this->image)) {
            // check if it is a full url
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }

            return config('app.url').'/images/'.$this->image;
        }

        return config('app.url').'/images/articles/no-image.png';
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'content' => $this->content,
            'image' => $this->imageUrl(),
            'status' => $this->status,
            'published_at' => Carbon::parse($this->published_at)->format('Y-m-d H:i:s'),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
            'metas' => ArticleMetaResource::collection($this->whenLoaded('metas')),
        ];
    }
}
