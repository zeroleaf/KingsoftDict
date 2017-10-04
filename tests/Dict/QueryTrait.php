<?php
/**
 * Created by PhpStorm.
 * User: zeroleaf
 * Date: 公元17-10-04
 * Time: 17:44
 */

namespace Zeroleaf\Test\Kingsoft\Dict;

use Zeroleaf\Kingsoft\Dict\QueryRequest;

/**
 * Trait QueryTrait
 *
 * @package Zeroleaf\Test\Kingsoft\Dict
 */
trait QueryTrait
{
    /**
     * @param string $word
     */
    protected function query($word)
    {
        $request = new QueryRequest($word);

        return $this->client->get($request);
    }
}