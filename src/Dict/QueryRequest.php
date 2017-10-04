<?php
/**
 * Created by PhpStorm.
 * User: zeroleaf
 * Date: 公元17-10-04
 * Time: 15:31
 */

namespace Zeroleaf\Kingsoft\Dict;

use Zeroleaf\Kingsoft\Request\Request;

/**
 * Request for looking up word meaning.
 *
 * @method $this|mixed word($val = null)
 *
 * @package Zeroleaf\Kingsoft\Dict
 */
class QueryRequest extends Request
{
    const LIST_BASE_INFO     = 1;    // 基础释义
    const LIST_COLLINS       = 3;    // 柯林斯高阶英汉双解学习词典
    const LIST_EE_MEAN       = 4;    // 英英词典
    const LIST_TRADE_MEANS   = 5;    // 行业词典
    const LIST_SENTENCE      = 8;    // 双语例句
    const LIST_NETMEAN       = 9;    // 网络释义
    const LIST_AUTH_SENTENCE = 10;   // 权威例句
    const LIST_SYNONYM       = 12;   // 同义词
    const LIST_ANTONYM       = 13;   // 反义词
    const LIST_PHRASE        = 14;   // 词组搭配
    const LIST_ENCYCLOPEDIA  = 18;   // 百科全书
    const LIST_CET_FOUR      = 21;   // 四级真题
    const LIST_BIDEC         = 3003; // 英汉双向大词典
    const LIST_JUSHI         = 3005; // 例句

    const LIST_DELIMITER = ',';      // list 字段分隔符

    /**
     * @var string
     */
    protected $uri = 'http://www.iciba.com/index.php';

    /**
     * @var string
     */
    protected $parameterOption = 'query';

    /**
     * QueryRequest constructor.
     *
     * @param string $word
     * @param array  $options
     */
    public function __construct($word, array $options = [])
    {
        parent::__construct($options);

        // 初始化设置
        $this->setOption('query', [
            'c'    => 'search',
            'a'    => 'getWordMean',
            'word' => $word,
            'list' => implode(self::LIST_DELIMITER, [
                self::LIST_BASE_INFO,
                self::LIST_TRADE_MEANS,
                self::LIST_SENTENCE,
                self::LIST_NETMEAN,
                self::LIST_SYNONYM,
                self::LIST_ANTONYM,
                self::LIST_PHRASE,
                self::LIST_ENCYCLOPEDIA,
                self::LIST_CET_FOUR,
            ]),
        ]);
    }

    /**
     * @param int|array $fields
     *
     * @return $this
     */
    public function with($fields)
    {
        return $this->setOption('query.list', implode(',',
                array_unique(array_merge(explode(',', $this->getOptionKey('query.list')), (array) $fields))
            )
        );
    }

    /**
     * @param int|array $fields
     *
     * @return $this
     */
    public function without($fields)
    {
        return $this->setOption('query.list', implode(',',
                array_unique(array_diff(explode(',', $this->getOptionKey('query.list')), (array) $fields))
            )
        );
    }

    /**
     * @return string
     */
    protected function getResponseClass()
    {
        return QueryResponse::class;
    }

}