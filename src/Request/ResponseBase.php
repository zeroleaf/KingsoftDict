<?php
/**
 * Created by PhpStorm.
 * User: zeroleaf
 * Date: 公元17-10-04
 * Time: 16:19
 */

namespace Zeroleaf\Kingsoft\Request;

use Psr\Http\Message\ResponseInterface as PsrResponse;

/**
 * Class ResponseBase
 *
 * @package Zeroleaf\Kingsoft\Request
 */
abstract class ResponseBase implements Response
{
    /**
     * Decoded original response body text.
     *
     * @var array
     */
    protected $data;

    /**
     * @var PsrResponse
     */
    protected $original;

    /**
     * ResponseBase constructor.
     *
     * Use from factory method instead.
     *
     * @param PsrResponse $original
     */
    protected function __construct(PsrResponse $original)
    {
        $this->original = $original;

        $this->initialize();
    }

    /**
     * According to the original response, initialize this response.
     * Usually, fill $data field.
     *
     * For subclass override.
     */
    protected function initialize()
    {
    }

    /**
     * @inheritdoc
     */
    public static function from(PsrResponse $response)
    {
        return new static($response);
    }

    /**
     * Get val from data by dot key.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function dataGet($key, $default = null)
    {
        return data_get($this->data, $key, $default);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->dataGet($name);
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $key = snake_case($name);
        $num = count($arguments);

        if ($num === 0) {
            return $this->dataGet($key);
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->original->getBody();
    }
}