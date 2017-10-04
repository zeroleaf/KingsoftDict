<?php
/**
 * Created by PhpStorm.
 * User: zeroleaf
 * Date: 公元17-10-04
 * Time: 17:42
 */

namespace Zeroleaf\Test\Kingsoft\Dict;

use Zeroleaf\Kingsoft\Dict\QueryResponse;
use Zeroleaf\Test\Kingsoft\TestCase;

/**
 * Class QueryResponseTest
 *
 * @package Zeroleaf\Test\Kingsoft\Dict
 */
class QueryResponseTest extends TestCase
{
    use QueryTrait;

    /**
     * 单词 go 的响应测试.
     *
     * 相应结果: http://www.iciba.com/index.php?a=getWordMean&c=search&list=1%2C2%2C3%2C4%2C5%2C8%2C9%2C10%2C12%2C13%2C14%2C18%2C21%2C22%2C3003%2C3005&word=go
     */
    public function testResponseGo()
    {
        /** @var QueryResponse $response */
        $response = $this->query('go');

        $this->assertEquals('go', $response->name());

        // 单词变形
        $this->assertEquals(['goes'], $response->exchange('word_pl'));
        $exchange     = $response->exchange();
        $exchangeKeys = [
            "word_pl", "word_past", "word_done", "word_ing", "word_third", "word_er",
            "word_est", "word_prep", "word_adv", "word_verb", "word_noun", "word_adj", "word_conn",
        ];
        foreach ($exchangeKeys as $exchangeKey) {
            $this->assertArrayHasKey($exchangeKey, $exchange);
        }

        // 音标及其发音
        $this->assertEquals('gəʊ', $response->ph('ph_en'));
        $ph     = $response->ph();
        $phKeys = ['ph_en', 'ph_am', 'ph_other', 'ph_en_mp3', 'ph_am_mp3', 'ph_tts_mp3'];
        foreach ($phKeys as $phKey) {
            $this->assertArrayHasKey($phKey, $ph);
        }

        // 单词释义
        $this->assertTrue(is_array($response->means()));
        $this->assertEquals(["走", "离开", "去做", "进行",], $response->means('vi.'));

        // 专业释义
        $this->assertTrue(is_array($response->reducedTradeMeans()));
        $this->assertEquals(['围棋'], $response->reducedTradeMeans('旅游'));

        // 双语例句
        $sentences = $response->sentences();
        $this->assertTrue(is_array($sentences));
        $this->assertEquals(3, count($sentences));
    }
}
