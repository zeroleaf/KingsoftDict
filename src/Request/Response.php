<?php
/**
 * Created by PhpStorm.
 * User: zeroleaf
 * Date: 公元17-10-04
 * Time: 14:19
 */

namespace Zeroleaf\Kingsoft\Request;

use Psr\Http\Message\ResponseInterface as PsrResponse;

/**
 * Interface Response
 *
 * @package Zeroleaf\Kingsoft\Request
 */
interface Response
{
    /**
     * Indicate this response is valid or not.
     *
     * @return bool
     */
    public function successful();

    /**
     * @param PsrResponse $response
     *
     * @return static
     */
    public static function from(PsrResponse $response);
}