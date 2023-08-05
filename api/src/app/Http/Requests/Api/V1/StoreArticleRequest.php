<?php

namespace App\Http\Requests\Api\V1;

use App\Validators\Articles\StoreArticleValidator;
use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    public function __construct(protected StoreArticleValidator $articleValidator)
    {
    }

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
        return $this->articleValidator->rules();
    }
}
