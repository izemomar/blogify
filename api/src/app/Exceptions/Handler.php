<?php

namespace App\Exceptions;

use App\Concerns\Api\JsonableResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use JsonableResponse;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Handle an API exception.
     *
     * @param  \Throwable  $exception The exception to handle.
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleApiException(Throwable $exception)
    {
        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            return $this->respondWithValidationError(
                message: $exception->getMessage(),
                errors: $exception->errors()
            );
        }

        if ($exception instanceof \Illuminate\Auth\AuthenticationException || $exception instanceof \Illuminate\Auth\Access\AuthorizationException || $exception instanceof \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException) {
            return $this->respondWithError(
                message: $exception->getMessage(),
                statusCode: Response::HTTP_UNAUTHORIZED
            );
        }

        if ($exception instanceof HttpException) {
            return $this->respondWithError(
                message: $exception->getMessage(),
                statusCode: $exception->getStatusCode()
            );
        }

        if ($exception instanceof BaseException) {
            return $this->respondWithCustomError($exception);
        }

        return $this->respondWithError(
            message: $exception->getMessage(),
            statusCode: Response::HTTP_INTERNAL_SERVER_ERROR,
        );
    }

    public function render($request, Throwable $exception)
    {
        if ($request->wantsJson()) {
            return $this->handleApiException($exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
