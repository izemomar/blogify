<?php

namespace App\Validators\Articles;

use App\DTOs\Articles\ArticleDTO;
use App\Enums\ArticleStatusEnum;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreArticleValidator
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'summary' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'status' => ['required', 'string', Rule::in(ArticleStatusEnum::getValues())],
            'image' => ['nullable', 'image', 'max:3000', 'mimes:jpg,jpeg,png'],
        ];
    }

    public function validate(ArticleDTO $articleDTO): void
    {
        validator($articleDTO->toArray(), $this->rules())->validate();
    }
}
