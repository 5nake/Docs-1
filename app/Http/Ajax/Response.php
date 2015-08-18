<?php
namespace App\Http\Ajax;

use SplPriorityQueue;
use \Illuminate\Http\Response as HttpResponse;

/**
 * Class Response
 * @package App\Http\Ajax
 */
class Response extends HttpResponse
{
    const VERSION = '1.0.0';

    const STATUS_SUCCESS    = 'success';
    const STATUS_ERROR      = 'error';

    /**
     * @var SplPriorityQueue
     */
    private static $actions = null;

    /**
     * @return SplPriorityQueue
     */
    public static function boot()
    {
        if (static::$actions === null) {
            static::$actions = new SplPriorityQueue;
        }
        return static::$actions;
    }

    /**
     * @param mixed|string $response
     * @param int $code
     * @param array $headers
     */
    public function __construct($response, $code, $headers = [])
    {
        static::boot();
        parent::__construct($response, $code, $headers);
    }

    /**
     * @param array $data
     * @param int $code
     * @param array $headers
     * @return static
     */
    public static function createFromArray(array $data, $code = 200, $headers = [])
    {
        $data = [
            'version'   => static::VERSION,
            'status'    => $code <= 399
                ? static::STATUS_SUCCESS
                : static::STATUS_ERROR,
            'response'  => $data,
            'actions'   => iterator_to_array(static::$actions)
        ];

        $response = new static(json_encode($data), $code, $headers);

        $response->header('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param \Exception $e
     * @param int $code
     * @param array $headers
     * @return Response
     */
    public static function createFromException(\Exception $e, $code = 500, $headers = [])
    {
        $response = [
            'code'    => $e->getCode(),
            'message' => $e->getMessage(),
        ];

        if (config('app.debug')) {
            $response['file']  = $e->getFile();
            $response['line']  = $e->getLine();
            $response['class'] = get_class($e);
        }

        if (method_exists($e, 'getStatusCode')) {
            $code = $e->getStatusCode();
        }

        if (method_exists($e, 'getHeaders')) {
            $headers = $e->getHeaders();
        }

        return static::createFromArray(
            $response,
            $code,
            $headers
        );
    }


    /**
     * @param $action
     * @param null $order
     * @return SplPriorityQueue
     */
    public static function attachAction($action, $order = null)
    {
        static::boot();

        if ($order === null) {
            $order = static::$actions->count();
        }

        static::$actions->insert($action, $order);

        return static::$actions;
    }
}
Response::boot();
