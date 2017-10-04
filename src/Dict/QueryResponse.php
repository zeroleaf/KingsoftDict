<?php
/**
 * Created by PhpStorm.
 * User: zeroleaf
 * Date: 公元17-10-04
 * Time: 16:12
 */

namespace Zeroleaf\Kingsoft\Dict;

/**
 * Class QueryResponse
 *
 * @package Zeroleaf\Kingsoft\Dict
 */
class QueryResponse extends DictResponse
{
    /**
     * @inheritdoc
     */
    public function successful()
    {
        return $this->errno() === 0;
    }

    //

    /**
     * 错误码. 0 表示成功.
     *
     * @return int
     */
    public function errno()
    {
        return (int) $this->dataGet('errno');
    }

    /**
     * 错误消息.
     *
     * @return string
     */
    public function errmsg()
    {
        return $this->dataGet('errmsg');
    }

    // baesInfo

    /**
     * 基础释义.
     *
     * @param string $key
     * @param array  $default
     *
     * @return array|mixed
     */
    public function baesInfo($key = null, $default = null)
    {
        $targetKey = 'baesInfo' . ($key ? ".{$key}" : '');

        return $this->dataGet($targetKey, $default);
    }

    /**
     * 实际查询的单词名称.
     *
     * @return string
     */
    public function name()
    {
        return $this->baesInfo('word_name');
    }

    /**
     * 单词变形.
     *
     * 默认返回一个关联数组, 有如下 Key:
     *
     * - "word_pl"      复数
     * - "word_past"    过去式
     * - "word_done"    完成时
     * - "word_ing"     进行时
     * - "word_third"   第三人称
     * - "word_er"      对应的人,
     * - "word_est"     最高级,
     * - "word_prep"    相关的介词,
     * - "word_adv"     相关的副词
     * - "word_verb"    相关的动词
     * - "word_noun"    相关的名词
     * - "word_adj"     相关的形容词
     * - "word_conn"    相关的连词
     *
     * Key 值为一个数组.
     *
     * 如果指定了 Key, 则只返回相应 Key 对应的值.
     *
     * @param string $key
     *
     * @return array
     */
    public function exchange($key = null)
    {
        $targetKey = 'exchange' . ($key ? ".{$key}" : '');

        return $this->baesInfo($targetKey, []);
    }

    /**
     * 音标及其发音.
     *
     * 默认返回一个包含如下 Key 的关联数组:
     *
     * - ph_en          英式发音
     * - ph_am          美式发音
     * - ph_other       其他发音
     * - ph_en_mp3      英式发音文件
     * - ph_am_mp3      美式发音文件
     * - ph_tts_mp3     其他发音文件
     *
     * Key 值为一个字符串.
     *
     * 如果指定了 Key, 则只返回相应 Key 对应的值.
     *
     * @param string|null $key
     *
     * @return array|string
     */
    public function ph($key = null)
    {
        $symbols = $this->baesInfo('symbols.0', []);

        return $key ? data_get($symbols, $key, []) : array_only($symbols, [
            'ph_en', 'ph_am', 'ph_other', 'ph_en_mp3', 'ph_am_mp3', 'ph_tts_mp3',
        ]);
    }

    /**
     * 单词释义.
     *
     * 默认返回一个关联数组, 该数组的 Key 为词性, 如 vi. 等; 值为该词性下的释义(索引数组).
     *
     * 如果指定了 Key, 则只返回该 key 对应的值.
     *
     * @param string $part
     *
     * @return array
     */
    public function means($part = null)
    {
        $parts = $this->dataGet('baesInfo.symbols.0.parts', []);

        $means = $this->reduceKV($parts, 'part', 'means');

        return $part ? array_get($means, $part) : $means;
    }

    /**
     * 将索引数组改为关联数组, key 为元素的 idxKey 值, val 为元素的 valKey 值.
     *
     * @param array  $array
     * @param string $idxKey
     * @param string $valKey
     *
     * @return array
     */
    protected function reduceKV(array $array, $idxKey, $valKey)
    {
        return array_reduce($array, function ($carry, $item) use ($idxKey, $valKey) {
            $key = $item[$idxKey];

            $carry[$key] = array_unique(array_merge(array_get($carry, $key, []), $item[$valKey]));

            return $carry;
        }, []);
    }

    // trade_means

    /**
     * 专业释义.
     *
     * @return array
     */
    public function tradeMeans()
    {
        return $this->dataGet('trade_means', []);
    }

    /**
     * 格式化后的专业释义.
     *
     * 默认返回一个关联数组, key 为专业名称(中文), val 为对应的专业释义(索引数组).
     *
     * 如果指定了 $trade, 则只返回该 key 对应的值.
     *
     * @param string|null $trade
     *
     * @return array
     */
    public function reducedTradeMeans($trade = null)
    {
        $tradeMeans = $this->tradeMeans();

        $trades = $this->reduceKV($tradeMeans, 'word_trade', 'word_mean');

        return $trade ? array_get($trades, $trade) : $trades;
    }

    // sentence

    /**
     * 双语例句.
     *
     * 返回一个索引数组, 数组中的每个元素为包含有如下 key 的数组:
     *
     * - Network_id     ID 标识
     * - Network_en     英文原句
     * - Network_cn     中文翻译
     * - tts_mp3        (英文)发音
     * - tts_size       音频文件大小
     * - source_type    (基本为零)
     * - source_id      (基本为零)
     * - source_title   (基本 普通双语例句)
     *
     * @return array
     */
    public function sentences()
    {
        return $this->dataGet('sentence');
    }

    // netmean

    /**
     * 网络释义.
     *
     * @return array
     */
    public function netmean()
    {
        return $this->dataGet('netmean');
    }

    // phrase

    /**
     * 词组.
     *
     * @return array
     */
    public function phrase()
    {
        return $this->dataGet('phrase', []);
    }

    /**
     * 词组.
     *
     * 返回一个关联数组, key 为词组名称; val 为词组内容(索引素组), 该数组结构如下:
     *
     * - "jx_en_mean": "bearing in mind its limitations (said when qualifying praise of something)",
     * - "jx_cn_mean": "考虑到它的局限性（在找理由表扬某事物时说）",
     * - "lj": [
     *          {
     *              - "lj_ly": "the book is a useful catalogue as far as it goes.",
     *              - "lj_ls": "就这本书本身而言，它是个有用的目录。"
     *          }
     *         ]
     *
     * @return array
     */
    public function reducedPhrases()
    {
        $phrase = $this->phrase();

        return $this->reduceKV($phrase, 'cizu_name', 'jx');
    }

    /**
     * 同义词.
     *
     * @return array
     */
    public function synonym()
    {
        return $this->dataGet('synonym');
    }

    /**
     * 反义词.
     *
     * @return array
     */
    public function antonym()
    {
        return $this->dataGet('antonym');
    }

    /**
     * 百科全书.
     *
     * @return array
     */
    public function encyclopedia()
    {
        return $this->dataGet('encyclopedia');
    }

    /**
     * 柯林斯高阶英汉双解学习词典
     *
     * @return array
     */
    public function collins()
    {
        return $this->dataGet('collins');
    }

    /**
     * 英语释义.
     *
     * @return array
     */
    public function eeMean()
    {
        return $this->dataGet('ee_mean');
    }

    /**
     * 权威例句.
     *
     * @return array
     */
    public function authSentence()
    {
        return $this->dataGet('auth_sentence');
    }

    /**
     * 英汉双向大词典.
     *
     * @return array
     */
    public function bidec()
    {
        return $this->dataGet('bidec');
    }

    /**
     * 例句.
     *
     * @return array
     */
    public function jushi()
    {
        return $this->dataGet('jushi');
    }
}