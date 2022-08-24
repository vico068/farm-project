<?php

namespace App\Exceptions;

use App\Infrastructure\ApiResponse;
use BadMethodCallException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{

    use ApiResponse;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {

        if ($request->expectsJson() || $request->wantsJson()) {
            if ($exception instanceof PostTooLargeException) {
                return $this->error('O tamanho do arquivo anexado deve ser menor que " . ini_get("upload_max_filesize") . "B"', 400);
            }

            if ($exception instanceof AuthenticationException) {
                return $this->error('Não autenticado ou Token expirado, faça login', 401);
            }
            if ($exception instanceof ThrottleRequestsException) {
                return $this->error('Too Many Requests,Please Slow Down', 401);
            }
            if ($exception instanceof ModelNotFoundException) {
                return $this->error('Entry for ' . str_replace('App\\', '', $exception->getModel()) . ' not found', 422);
            }
            if ($exception instanceof ValidationException) {
                return $this->error($exception->getMessage(), 404);
            }
            if ($exception instanceof QueryException) {
                return $this->error('Houve problema com a consulta: ' . $exception->getMessage(), 500);
            }
            if ($exception instanceof HttpResponseException) {
                return $this->error("Houve um problema com uma consulta! ", 500);
            }
            if ($exception instanceof \Error) {
                return $this->error("Houve um problema com uma consulta" . $exception->getMessage(), 500);
            }
            if ($exception instanceof NotFoundHttpException) {
                return $this->error("Rota não encontrada!", 404);
            }
            if ($exception instanceof MethodNotAllowedHttpException) {
                return $this->error("Metodo não suportado!", 500);
            }
            if ($exception instanceof BadMethodCallException) {
                return $this->error("Metodo não suportado!", 500);
            }

            if ($exception instanceof AccessDeniedHttpException) {
                return $this->error("Acesso negado!", 500);
            }
        }
        return parent::render($request, $exception);
    }
}
