<?php
/**
 * Created by PhpStorm.
 * User: zeroleaf
 * Date: 2017/10/15
 * Time: 下午3:54
 */

namespace Zeroleaf\Test\Kingsoft\Dict;

/**
 * Class SuggestionResponseTest
 *
 * @package Zeroleaf\Test\Kingsoft\Dict
 */
class SuggestionResponseTest extends TestCaseBase
{
    /**
     * 基本测试.
     */
    public function testSuggestion()
    {
        $response = $this->dict->suggest('h');

        $this->assertTrue($response->successful());
        $this->assertTrue(is_array($response->message()));
        $this->assertTrue(count($response->message()) === 10);
    }
}
