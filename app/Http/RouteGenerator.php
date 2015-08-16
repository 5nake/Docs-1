<?php
namespace App\Http;

use ArrayAccess;
use ArrayObject;
use BadMethodCallException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use IteratorAggregate;

/**
 * Class RouteGenerator
 * @package App\Http
 *
 * @method RouteGenerator as (string $alias)
 */
class RouteGenerator extends ArrayObject
    implements ArrayAccess, Arrayable, IteratorAggregate
{
    /**
     * @var string
     */
    protected $class = '';
    /**
     * @var string
     */
    protected $method = '';
    /**
     * @var string
     */
    protected $alias = '';

    /**
     * @var array
     */
    protected $cache = [];

    /**
     * @var array
     */
    protected $before = [];

    /**
     * @param $class
     * @param $method
     */
    public function __construct($class, $method)
    {
        $this->class = $class;
        $this->method = $method;
        $this->alias = Str::snake($class) . '.' . $method;
    }

    /**
     * @param $alias
     * @return $this
     */
    protected function _as($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * @param $methods
     * @return $this
     */
    protected function before(...$methods)
    {
        $this->before = array_merge($this->before, $methods);

        return $this;
    }

    /**
     * @param $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, $args = [])
    {
        $method = '_' . $method;

        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $args);
        }
        throw new BadMethodCallException;
    }

    /**
     * @return array
     */
    public function &toArray()
    {
        if ($this->cache === []) {
            $this->cache = [
                'before' => $this->before,
                'uses'   => sprintf('\\%s@%s', $this->class, $this->method),
                'as'     => $this->alias,
            ];
        }

        parent::__construct($this->cache);

        return $this->cache;
    }

    /**
     * @return \Traversable|\Generator|void
     */
    public function getIterator()
    {
        foreach ($this->toArray() as $key => $val) {
            yield $key => $val;
        }
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->toArray());
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->toArray()[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->toArray()[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        throw new BadMethodCallException;
    }
}
