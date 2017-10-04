<?php
/**
 * Created by PhpStorm.
 * User: zeroleaf
 * Date: 公元17-10-04
 * Time: 14:21
 */

namespace Zeroleaf\Kingsoft\Request;

use GuzzleHttp\Client;

/**
 * Guzzle based http client implements.
 *
 * @package Zeroleaf\Kingsoft\Request
 */
class GuzzleHttpClient implements HttpClientInterface
{
    /**
     * @var Client
     */
    protected $client = null;

    /**
     * GuzzleHttpClient constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @inheritdoc
     */
    public function get(Request $request)
    {
        $result = $this->client->get($request->getUri(), $request->getOptions());

        $request->setResult($result);

        return $request->getResponse();
    }

}