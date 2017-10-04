<?php
/**
 * Created by PhpStorm.
 * User: zeroleaf
 * Date: 2017-10-04
 * Time: 14:19
 */

namespace Zeroleaf\Kingsoft\Request;

use Psr\Http\Message\ResponseInterface as PsrResponse;

/**
 * Class Request
 *
 * @method $this|mixed allowRedirects($val = null)
 * @method $this|mixed auth($val = null)
 * @method $this|mixed body($val = null)
 * @method $this|mixed cert($val = null)
 * @method $this|mixed cookies($val = null)
 * @method $this|mixed connectTimeout($val = null)
 * @method $this|mixed debug($val = null)
 * @method $this|mixed decodeContent($val = null)
 * @method $this|mixed delay($val = null)
 * @method $this|mixed expect($val = null)
 * @method $this|mixed forceIpResolve($val = null)
 * @method $this|mixed formParams($val = null)
 * @method $this|mixed headers($val = null)
 * @method $this|mixed httpErrors($val = null)
 * @method $this|mixed json($val = null)
 * @method $this|mixed multipart($val = null)
 * @method $this|mixed onHeaders($val = null)
 * @method $this|mixed onStats($val = null)
 * @method $this|mixed progress($val = null)
 * @method $this|mixed proxy($val = null)
 * @method $this|mixed query($val = null)
 * @method $this|mixed readTimeout($val = null)
 * @method $this|mixed sink($val = null)
 * @method $this|mixed sslKey($val = null)
 * @method $this|mixed stream($val = null)
 * @method $this|mixed synchronous($val = null)
 * @method $this|mixed verify($val = null)
 * @method $this|mixed timeout($val = null)
 * @method $this|mixed version($val = null)
 *
 * @package Zeroleaf\Kingsoft\Request
 */
abstract class Request
{
    /**
     * @var string
     */
    protected $uri;

    /**
     * Request options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * The option to store request parameters.
     *
     * Can be
     *
     * - query
     * - form_params
     * - json
     *
     * @var string
     */
    protected $parameterOption = null;

    /**
     * All available options.
     *
     * @var array
     */
    protected static $availableOptions = [
        'allow_redirects',
        'auth',
        'body',
        'cert',
        'cookies',
        'connect_timeout',
        'debug',
        'decode_content',
        'delay',
        'expect',
        'force_ip_resolve',
        'form_params',
        'headers',
        'http_errors',
        'json',
        'multipart',
        'on_headers',
        'on_stats',
        'progress',
        'proxy',
        'query',
        'read_timeout',
        'sink',
        'ssl_key',
        'stream',
        'synchronous',
        'verify',
        'timeout',
        'version',
    ];

    /**
     * Original request response.
     *
     * @var PsrResponse
     */
    protected $result = null;

    /**
     * Request constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string $key
     *
     * @return null|mixed
     */
    public function getOption($key)
    {
        $optionKey = $this->getOptionKey($key);

        return $this->isPreferredDefinedOption($optionKey) ? data_get($this->options, $key) : null;
    }

    /**
     * @param string $key
     * @param mixed  $val
     *
     * @return $this
     */
    public function setOption($key, $val)
    {
        $optionKey = $this->getOptionKey($key);

        if ($this->isPreferredDefinedOption($optionKey)) {
            data_set($this->options, $key, $val);
        }

        return $this;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    protected function getOptionKey($key)
    {
        return array_first(explode('.', $key));
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    protected function isPreferredDefinedOption($key)
    {
        if (! in_array($key, self::$availableOptions)) {
            // TODO Add log
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param PsrResponse $response
     */
    public function setResult(PsrResponse $response)
    {
        $this->result = $response;
    }

    /**
     * @return bool
     */
    protected function isResponseOK()
    {
        $statusCode = $this->result->getStatusCode();

        return 200 <= $statusCode && $statusCode < 300;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        $responseClass = $this->isResponseOK()
            ? $this->getResponseClass()
            : ErrorResponse::class;

        return call_user_func("$responseClass::from", $this->result);
    }

    /**
     * The qualified response class for this request, which should implements
     * {@see \Zeroleaf\Kingsoft\Request\Response} interface.
     *
     * @return string
     */
    protected abstract function getResponseClass();

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return array|mixed
     */
    public function __call($name, $arguments)
    {
        $optionKey = snake_case($name);
        $numOfArgs = count($arguments);

        if ($this->isPreferredDefinedOption($optionKey)) {
            if ($numOfArgs === 0) {
                return $this->getOption($optionKey);
            }
            else {
                return $this->setOption($optionKey, ...$arguments);
            }
        }

        // Get or set value from parameter option.
        if (! $parameterOption = $this->parameterOption) {
            return $this;
        }

        $realOptionKey = "{$parameterOption}.{$optionKey}";
        if ($numOfArgs === 0) {
            return $this->getOption($realOptionKey);
        }
        else {
            return $this->setOption($realOptionKey, ...$arguments);
        }
    }
}