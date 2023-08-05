<?php

namespace App\Exceptions\Articles;

use App\Exceptions\BaseException;

class ArticleImageStorageException extends BaseException
{
    public function __construct($message = 'Article storage error', $code = 500)
    {
        parent::__construct(message: $message, statusCode: $code);
    }
}
