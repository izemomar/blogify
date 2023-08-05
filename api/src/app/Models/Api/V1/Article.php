<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class Article extends Model
{
    use HasFactory, HybridRelations;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'content',
        'published_at',
        'image',
        'status',
    ];

    public function scopeIsPublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeIsDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeIsArchived($query)
    {
        return $query->where('status', 'archived');
    }

    public function metas()
    {
        return $this->hasMany(ArticleMeta::class);
    }
}
