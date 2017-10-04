<?php
/**
 * Created by PhpStorm.
 * User: zeroleaf
 * Date: 2017/10/4
 * Time: 下午11:11
 */

namespace Zeroleaf\Kingsoft\Dict;


use Zeroleaf\Kingsoft\Request\ResponseBase;

/**
 * Class DictResponse
 *
 * @package Zeroleaf\Kingsoft\Dict
 */
abstract class DictResponse extends ResponseBase
{
    /**
     * @inheritdoc
     */
    protected function initialize()
    {
        $this->data = json_decode((string) $this, true);
    }
}