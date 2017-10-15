<?php
/**
 * Created by PhpStorm.
 * User: zeroleaf
 * Date: 公元17-10-04
 * Time: 15:28
 */

namespace Zeroleaf\Kingsoft\Dict;

use Zeroleaf\Kingsoft\Request\Request;

/**
 * 联想(推荐)请求.
 *
 * @method $this|mixed word($val = null)
 * @method $this|mixed nums($val = null) 建议个数, 最大值为 15
 * @method $this|mixed isNeedMean($val = null)
 *
 * @package Zeroleaf\Kingsoft\Dict
 */
class SuggestionRequest extends Request
{
    /**
     * @var string
     */
    protected $parameterOption = 'query';

    /**
     * @var string
     */
    protected $uri = 'http://dict-mobile.iciba.com/interface/index.php';

    /**
     * SuggestionRequest constructor.
     *
     * @param string $word
     * @param array  $options
     */
    public function __construct($word, array $options = [])
    {
        parent::__construct($options);

        // 生成默认请求参数
        $this->setOption('query', [
            'c'            => 'word',
            'm'            => 'getsuggest',
            'client'       => 6,

            // 可变参数
            'is_need_mean' => 1,
            'nums'         => 10,
            'word'         => $word,
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function getResponseClass()
    {
        return SuggestionResponse::class;
    }
}