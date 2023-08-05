<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Api\V1\Articles\DeleteArticleAction;
use App\Actions\Api\V1\Articles\GetArticleByIdAction;
use App\Actions\Api\V1\Articles\PaginateArticlesAction;
use App\Http\Controllers\Controller;
use App\Actions\Api\V1\Articles\StoreArticleAction;
use App\Actions\Api\V1\Articles\UpdateArticleAction;
use App\Concerns\Api\JsonableResponse;
use App\DTOs\Articles\ArticlePaginationDTO;
use App\DTOs\Articles\ArticleDTO;
use App\Http\Requests\Api\V1\StoreArticleRequest;
use App\Http\Requests\Api\V1\UpdateArticleRequest;
use App\Http\Requests\PaginateArticlesRequest;
use App\Http\Resources\Api\V1\ArticleResource;
use App\Models\Api\V1\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    use JsonableResponse;

    public function __construct(protected StoreArticleAction $storeArticleAction, protected GetArticleByIdAction $getArticleByIdAction, protected UpdateArticleAction $updateArticleAction, protected DeleteArticleAction $deleteArticleAction, protected PaginateArticlesAction $paginateArticlesAction)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PaginateArticlesRequest $request)
    {
        $paginationDto = ArticlePaginationDTO::fromRequest($request->validated());

        $articles = $this->paginateArticlesAction->execute($paginationDto);

        return $this->respondWithPagination(
            data: ArticleResource::collection($articles->items()),
            message: 'Articles retrieved successfully.',
            paginator: $articles
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $article = $this->getArticleByIdAction->execute($id);
        return $this->respondWithSuccess(data: $article);
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
    public function update(UpdateArticleRequest $request, int $id)
    {
        $dto = ArticleDTO::fromRequest($request->validated());

        $article = $this->updateArticleAction->execute($id, $dto);

        return $this->respondWithSuccess(data: $article);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->deleteArticleAction->execute($id);

        return $this->respondWithSuccess();
    }
}
