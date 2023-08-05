<?php

namespace App\Http\Requests;

use App\Enums\ArticleStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaginateArticlesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'page' => ['nullable', 'integer', 'min:1'],
            'perPage' => ['nullable', 'integer', 'min:1'],
            'search' => ['nullable', 'string', 'max:255'],
            'orderBy' => ['nullable', 'string', 'in:published_at,created_at,updated_at'],
            'dir' => ['nullable', 'string', 'in:asc,desc'],
            'include' => ['nullable', 'array', 'in:metas'],
            'status' => ['nullable', 'string', Rule::in(ArticleStatusEnum::getValues())],
        ];
    }
}
