<?php

namespace App\Exceptions;

// use Exception;
// use Illuminate\Validation\ValidationException;
// use Illuminate\Auth\Access\AuthorizationException;
// use Illuminate\Database\Eloquent\ModelNotFoundException;
// use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
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
    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        /***************ERROR PERSONALIZADO*********COMENTAR ESTO Y DESCOMENTAR LA LINEA QUE ESTA COMENTADA PARA CONTROL ORIGINAL DE ERRORES***********/
        /*if (view()->exists('errors.'.$e->getStatusCode()))
        {
            return response()->view('errors.'.$e->getStatusCode(), [], $e->getStatusCode());
        }
        else
        {
            return parent::render($request, $e);
        }*/
        /***************FIN ERROR PERSONALIZADO********************/
        
        return parent::render($request, $e);
    }
}
