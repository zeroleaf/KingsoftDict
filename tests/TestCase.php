<?php
/**
 * Created by PhpStorm.
 * User: zeroleaf
 * Date: 公元17-10-04
 * Time: 16:33
 */

namespace Zeroleaf\Test\Kingsoft;

use Zeroleaf\Kingsoft\Request\GuzzleHttpClient;
use Zeroleaf\Kingsoft\Request\HttpClientInterface;

/**
 * Class TestCase
 *
 * @package Zeroleaf\Test\Kingsoft
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var HttpClientInterface
     */
    protected $client;

    public function setup()
    {
        $this->client = new GuzzleHttpClient();
    }
}