<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Throwable;

/**
 * The base exception class.
 *
 * @method array toArray()
 */
class BaseException extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @param  string  $message The exception message.
     * @param  int  $statusCode The HTTP status code.
     * @param  array  $details The exception details.
     * @param  \Throwable|null  $previous The previous exception.
     */
    public function __construct(
        string $message,
        protected int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR,
        protected array $details = [],
        protected ?Throwable $previous = null
    ) {
        parent::__construct($message, $statusCode, $previous);
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'details' => $this->details,
        ];
    }

    /**
     * Get the HTTP status code.
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Set the HTTP status code.
     *
     * @param  int  $statusCode The HTTP status code.
     */
    public function setStatusCode(int $statusCode): static
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Get the exception details.
     */
    public function getDetails(): array
    {
        return $this->details;
    }

    /**
     * Set the exception details.
     *
     * @param  array  $details The exception details.
     */
    public function setDetails(array $details): static
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Set the previous exception.
     *
     * @param  \Throwable|null  $previous The previous exception.
     */
    public function setPrevious(?Throwable $previous): static
    {
        $this->previous = $previous;

        return $this;
    }
}
