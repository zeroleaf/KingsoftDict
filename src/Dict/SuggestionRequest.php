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
 * Class SuggestionRequest
 *
 * @package Zeroleaf\Kingsoft\Dict
 */
class SuggestionRequest extends Request
{
    /**
     * @inheritdoc
     */
    protected function getResponseClass()
    {
        return SuggestionResponse::class;
    }
}