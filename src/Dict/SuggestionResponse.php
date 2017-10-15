<?php
/**
 * Created by PhpStorm.
 * User: zeroleaf
 * Date: 2017/10/4
 * Time: 下午11:07
 */

namespace Zeroleaf\Kingsoft\Dict;

/**
 * Class SuggestionResponse
 *
 * @package Zeroleaf\Kingsoft\Dict
 */
class SuggestionResponse extends DictResponse
{
    /**
     * @inheritdoc
     */
    public function successful()
    {
        return $this->status() === 1;
    }

    /**
     * 响应码.
     *
     * - 1: 成功
     * - 2: 失败
     *
     * @return int
     */
    public function status()
    {
        return (int) $this->dataGet('status');
    }

    /**
     * 搜索建议.
     *
     * @return array
     */
    public function message()
    {
        return (array) $this->dataGet('message', []);
    }
}