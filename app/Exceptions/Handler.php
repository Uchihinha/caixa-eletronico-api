<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function sendValidationExceptionResponse(ValidationException $e) {
        return new JsonResponse(
            $e->errors(),
            $e->status
        );
    }

    public function render($request, \Throwable $exception)
    {
        if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException)
            throw new NotFoundHttpException('Oops...registro não encontrado!');
        else if ($exception instanceof ValidationException)
            return $this->sendValidationExceptionResponse($exception);

        $response = ['message' => $exception->getMessage()];

        $statusCode = 500;

        if ($this->isHttpException($exception)) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = $exception->getCode() > 0 && $exception->getCode() <= 500 ? $exception->getCode() : 500;
        }

        return new JsonResponse(
            $response,
            $statusCode,
            $this->isHttpException($exception) ? $exception->getHeaders() : [],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );
    }
}
