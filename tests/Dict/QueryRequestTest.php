<?php
/**
 * Created by PhpStorm.
 * User: zeroleaf
 * Date: 公元17-10-04
 * Time: 16:33
 */

namespace Zeroleaf\Test\Kingsoft\Dict;

use Zeroleaf\Kingsoft\Dict\QueryRequest;

/**
 * Class QueryRequestTest
 *
 * @package Zeroleaf\Test\Kingsoft\Dict
 */
class QueryRequestTest extends TestCaseBase
{
    /**
     * 请求中的字段跟相应中的相应字段之间的映射关系.
     *
     * @param string $field
     *
     * @return array
     */
    protected function fieldKeyMap($field = null)
    {
        $map = [
            QueryRequest::LIST_BASE_INFO     => 'baesInfo',
            QueryRequest::LIST_COLLINS       => 'collins',
            QueryRequest::LIST_EE_MEAN       => 'ee_mean',
            QueryRequest::LIST_TRADE_MEANS   => 'trade_means',
            QueryRequest::LIST_SENTENCE      => 'sentence',
            QueryRequest::LIST_NETMEAN       => 'netmean',
            QueryRequest::LIST_AUTH_SENTENCE => 'auth_sentence',
            QueryRequest::LIST_SYNONYM       => 'synonym',
            QueryRequest::LIST_ANTONYM       => 'antonym',
            QueryRequest::LIST_PHRASE        => 'phrase',
            QueryRequest::LIST_ENCYCLOPEDIA  => 'encyclopedia',
            QueryRequest::LIST_BIDEC         => 'bidec',
            QueryRequest::LIST_JUSHI         => 'jushi',
            //
            // QueryRequest::LIST_CET_FOUR,
        ];

        return is_null($field) ? $map : array_get($map, $field, null);
    }

    /**
     * 请求字段测试.
     */
    public function testFields()
    {
        $this->validateWordFieldsExistence('go', [
            QueryRequest::LIST_BASE_INFO,
            QueryRequest::LIST_TRADE_MEANS,
            QueryRequest::LIST_SENTENCE,
            QueryRequest::LIST_SYNONYM,
            QueryRequest::LIST_ANTONYM,
            QueryRequest::LIST_PHRASE,
        ]);

        $this->validateWordFieldsExistence('go', [
            QueryRequest::LIST_BASE_INFO,
            QueryRequest::LIST_TRADE_MEANS,
            QueryRequest::LIST_SENTENCE,
            QueryRequest::LIST_SYNONYM,
            QueryRequest::LIST_ANTONYM,
            QueryRequest::LIST_PHRASE,
            QueryRequest::LIST_NETMEAN,
            QueryRequest::LIST_ENCYCLOPEDIA,
        ]);
    }

    /**
     * 验证请求中, 存在指定的字段; 未指定的字段不存在.
     *
     * @param string    $word
     * @param int|array $fields
     */
    protected function validateWordFieldsExistence($word, $fields)
    {
        $fields = (array) $fields;

        $response = $this->dict->query($word, $fields);

        // 验证请求的字段存在
        foreach ($fields as $field) {
            $rpKey = $this->fieldKeyMap($field);
            $this->assertTrue(isset($response->{$rpKey}));
        }

        // 验证不包含未请求的字段
        $unRequestFields = array_diff(array_keys($this->fieldKeyMap()), $fields);
        foreach ($unRequestFields as $unRequestField) {
            $rpKey = $this->fieldKeyMap($unRequestField);
            $this->assertFalse(isset($response->{$rpKey}));
        }
    }
}
