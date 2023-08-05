<?php

use App\Http\Resources\Api\V1\ArticleResource;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\ArticleController;

Route::get('/test', function () {
    $articles = \App\Models\Api\V1\Article::with('metas')->get();

    return response()->json(ArticleResource::collection($articles));
});


Route::apiResource('articles', ArticleController::class)
    ->only(['index', 'show', 'store', 'update', 'destroy']);
