<?php

use App\Exceptions\BaseException;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    throw new BaseException(message: 'Test exception.', statusCode: 500, details: ['foo' => 'bar']);
    return response()->json(['message' => 'Hello World!']);
});
