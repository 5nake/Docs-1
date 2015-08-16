<?php namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run as Whoops;
use App\Http\Ajax\Response as AjaxResponse;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
    ];



    /**
     * @param \Illuminate\Http\Request $request
     * @param Exception $e
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $e)
    {
        if ($request->ajax()) {
            return $this->getAjaxException($e);
        }

        if ($this->isHttpException($e)) {
            return $this->getHttpException($e);
        }

        if (config('app.debug')) {
            return $this->getDefaultException($e);
        }

        return parent::render($request, $e);
    }

    /**
     * @param $request
     * @param Exception $e
     * @return static
     */
    protected function getAjaxException(Exception $e)
    {
        return AjaxResponse::createFromException($e);
    }

    /**
     * @param $request
     * @param Exception $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getHttpException(Exception $e)
    {
        return $this->renderHttpException($e);
    }

    /**
     * @param $request
     * @param Exception $e
     * @return Response
     */
    protected function getDefaultException(Exception $e)
    {
        $whoops = new Whoops;
        $whoops->pushHandler(new PrettyPageHandler);

        return new Response($whoops->handleException($e), $e->getStatusCode(), $e->getHeaders());
    }
}
