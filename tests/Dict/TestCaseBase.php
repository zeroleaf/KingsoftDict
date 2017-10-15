<?php
/**
 * Created by PhpStorm.
 * User: zeroleaf
 * Date: 2017/10/15
 * Time: 下午2:47
 */

namespace Zeroleaf\Test\Kingsoft\Dict;

use Zeroleaf\Kingsoft\Dict;
use Zeroleaf\Test\Kingsoft\TestCase;

/**
 * Class TestCaseBase
 *
 * @package Zeroleaf\Test\Kingsoft\Dict
 */
class TestCaseBase extends TestCase
{
    /**
     * @var Dict
     */
    protected $dict;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->dict = Dict::getInstance();
    }

}