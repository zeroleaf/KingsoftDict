<?php
/**
 * Created by PhpStorm.
 * User: zeroleaf
 * Date: 公元17-10-04
 * Time: 16:33
 */

namespace Zeroleaf\Test\Kingsoft\Dict;

use Zeroleaf\Kingsoft\Dict\QueryRequest;
use Zeroleaf\Test\Kingsoft\TestCase;

/**
 * Class QueryRequestTest
 *
 * @package Zeroleaf\Test\Kingsoft\Dict
 */
class QueryRequestTest extends TestCase
{
    /**
     *
     */
    public function testRequestGo()
    {
        $request = new QueryRequest('go');

        $response = $this->client->get($request);

        $result = json_decode((string) $response);

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
