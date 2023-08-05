<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Actions\Api\V1\Articles\StoreArticleAction;
use App\Concerns\Api\JsonableResponse;
use App\DTOs\Articles\ArticleDTO;
use App\Http\Requests\Api\V1\StoreArticleRequest;
use App\Models\Api\V1\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    use JsonableResponse;

    public function __construct(protected StoreArticleAction $storeArticleAction)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $dto = ArticleDTO::fromRequest($request->validated());

        $article = $this->storeArticleAction->execute($dto);

        return $this->respondWithSuccess(statusCode: 201, data: $article);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }
}
