<?php
/**
 * Created by PhpStorm.
 * User: zeroleaf
 * Date: 2017/10/15
 * Time: 下午1:21
 */

namespace Zeroleaf\Kingsoft;

use Zeroleaf\Kingsoft\Dict\QueryRequest;
use Zeroleaf\Kingsoft\Dict\QueryResponse as Word;
use Zeroleaf\Kingsoft\Dict\SuggestionRequest;
use Zeroleaf\Kingsoft\Dict\SuggestionResponse as Suggestion;
use Zeroleaf\Kingsoft\Request\GuzzleHttpClient;
use Zeroleaf\Kingsoft\Request\HttpClientInterface;

/**
 * Class Dict
 *
 * @package Zeroleaf\Kingsoft
 */
final class Dict
{
    /**
     * @var HttpClientInterface
     */
    protected $client;

    /**
     * Singleton.
     *
     * @var static
     */
    protected static $instance;

    /**
     * Dict constructor.
     */
    protected function __construct()
    {
        // TODO DI
        $this->client = new GuzzleHttpClient();
    }

    /**
     * 获取词典实例.
     *
     * @return static
     */
    public static function getInstance()
    {
        if (! isset(self::$instance)) {
            self::$instance = new static;
        }

        return self::$instance;
    }

    /**
     * 查询单词.
     *
     * @param string $word    待查询的单词
     * @param array  $fields  结果中需要包含的字段
     * @param array  $options 请求选项
     *
     * @return Word
     */
    public function query($word, $fields = null, $options = [])
    {
        $request = new QueryRequest($word, $options);

        if (! is_null($fields)) {
            $request->fields((array) $fields);
        }

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->client->get($request);
    }

    /**
     * @param string $word       建议模板
     * @param int    $nums       建议数量
     * @param int    $isNeedMean 是否包含释义
     * @param array  $options    请求选项
     *
     * @return Suggestion
     */
    public function suggest($word, $nums = 10, $isNeedMean = 1, $options = [])
    {
        $request = new SuggestionRequest($word, $options);

        $request->nums($nums);
        $request->isNeedMean($isNeedMean);

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->client->get($request);
    }

}