<?php

namespace App\Concerns\Api;

use App\Exceptions\BaseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

trait JsonableResponse
{
    private function defaultSuccessResponse(string|null $message = null): array
    {
        return [
            'message' => $message ?? 'Operation successful.',
            'success' => true,
        ];
    }

    private function defaultErrorResponse(string|null $message = null): array
    {
        return [
            'message' => $message ?? 'Operation failed.',
            'success' => false,
        ];
    }

    /**
     * Respond with a success message.
     *
     * @param  mixed  $data       The data to return.
     * @param  string|null  $message    The success message to return.
     * @param  int  $statusCode  The status code to return.
     * @param  array  $headers    The headers to return.
     */
    protected function respondWithSuccess(
        mixed $data = null,
        string $message = null,
        int $statusCode = Response::HTTP_OK,
        array $headers = []
    ): JsonResponse {

        $response = $this->defaultSuccessResponse($message);

        if (is_null($data)) {
            return response()->json($response, $statusCode, $headers);
        }

        $response['data'] = isset($data['data']) ? $data['data'] : $data;

        return response()->json($response, $statusCode, $headers);
    }

    protected function respondWithPagination(
        mixed $data = null,
        LengthAwarePaginator $paginator,
        string $message = null,
        int $statusCode = Response::HTTP_OK,
        array $headers = []
    ): JsonResponse {
        $response = $this->defaultSuccessResponse($message);

        if (is_null($data)) {
            return response()->json($response, $statusCode, $headers);
        }

        $response['data'] = $data;

        $response['meta'] = [
            'current_page' => $paginator->currentPage(),
            'from' => $paginator->firstItem(),
            'last_page' => $paginator->lastPage(),
            'path' => $paginator->path(),
            'per_page' => $paginator->perPage(),
            'to' => $paginator->lastItem(),
            'total' => $paginator->total(),
        ];

        return response()->json($response, $statusCode, $headers);
    }

    /**
     * Respond with an error message.
     *
     * @param  string|null  $message    The error message to return.
     * @param  int  $statusCode The status code to return.
     * @param  array  $headers    The headers to return.
     */
    protected function respondWithError(
        string $message = null,
        int $statusCode = Response::HTTP_BAD_REQUEST,
        array $headers = []
    ): JsonResponse {

        $response = $this->defaultErrorResponse($message);

        return response()->json($response, $statusCode, $headers);
    }

    /**
     * Respond with a custom error message.
     *
     * @param  BaseException  $exception  The exception to return.
     */
    protected function respondWithCustomError(
        BaseException $exception,
    ): JsonResponse {

        $response = array_merge(
            ['success' => false],
            $exception->toArray()
        );

        return response()->json($response, $exception->getStatusCode());
    }

    /**
     * Respond with a validation error message.
     *
     * @param  string|null  $message The error message to return.
     * @param  array  $errors  The errors to return.
     */
    protected function respondWithValidationError(
        string $message = null,
        array $errors = [],
    ): JsonResponse {

        $response = $this->defaultErrorResponse($message);

        if (count($errors) > 0) {
            $response['errors'] = $errors;
        }

        return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
