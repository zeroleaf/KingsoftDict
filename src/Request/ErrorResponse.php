<?php
/**
 * Created by PhpStorm.
 * User: zeroleaf
 * Date: 公元17-10-04
 * Time: 16:17
 */

namespace Zeroleaf\Kingsoft\Request;

/**
 * Class ErrorResponse
 *
 * @package Zeroleaf\Kingsoft\Request
 */
class ErrorResponse extends ResponseBase
{
    /**
     * @return bool
     */
    public function successful()
    {
        return false;
    }

}