<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Jenssegers\Mongodb\Eloquent\Model;

class ArticleMeta extends Model
{
    use HasFactory, HybridRelations;

    protected $connection = 'mongodb';

    protected $fillable = [
        'article_id',
        'key',
        'value',
        'type',
    ];

    public function getValueAttribute($value)
    {
        if ($this->type === 'array') {
            return json_decode($value);
        } elseif ($this->type === 'boolean') {
            return (bool) $value;
        } elseif ($this->type === 'integer' || $this->type === 'int' || $this->type === 'number') {
            return (int) $value;
        } elseif ($this->type === 'float') {
            return (float) $value;
        }

        return $value;
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
