<?php
/**
 * Created by PhpStorm.
 * User: zeroleaf
 * Date: 2017/10/11
 * Time: 上午11:09
 */

namespace Zeroleaf\Test\Kingsoft\Dict;

/**
 * 联想请求测试类.
 *
 * @package Zeroleaf\Test\Kingsoft\Dict
 */
class SuggestionRequestTest extends TestCaseBase
{
    /**
     * 基础功能测试.
     */
    public function testSuggestion()
    {
        $response = $this->dict->suggest('h');

        $this->assertTrue($response->successful());
        $this->assertTrue(count($response->message()) > 0);
    }

    /**
     * 响应数量测试.
     */
    public function testNums()
    {
        $this->validateNums('h', 5);
        $this->validateNums('b', 10);
        $this->validateNums('k', 15); // 最大只支持15
    }

    /**
     * @param string $prefix
     * @param int    $nums
     */
    protected function validateNums($prefix, $nums)
    {
        $response = $this->dict->suggest($prefix, $nums);
        $this->assertTrue(count($response->message()) === $nums);
    }

    /**
     * 是否包含释义测试.
     */
    public function testIsNeedMean()
    {
        $this->assertFalse(empty($this->extractMeans('h', 1)));
        $this->assertTrue(empty($this->extractMeans('h', 0)));
    }

    /**
     * @param string $prefix
     * @param int    $isNeedMean
     *
     * @return array
     */
    protected function extractMeans($prefix, $isNeedMean)
    {
        $response = $this->dict->suggest($prefix, 10, $isNeedMean);

        return array_filter(
            array_map(function ($item) {
                return array_get($item, 'means');
            }, $response->message())
        );
    }

}
