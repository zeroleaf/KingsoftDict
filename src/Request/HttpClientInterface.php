<?php
/**
 * Created by PhpStorm.
 * User: zeroleaf
 * Date: 公元17-10-04
 * Time: 14:18
 */

namespace Zeroleaf\Kingsoft\Request;

/**
 * Interface HttpClientInterface
 *
 * @package Zeroleaf\Kingsoft\Request
 */
interface HttpClientInterface
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function get(Request $request);
}