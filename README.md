# KingsoftDict

金山词霸单词相关操作库, 依据 [jokermonn/-Api](https://github.com/jokermonn/-Api/blob/master/KingsoftDic.md) 提供的相关 API 说明实现.

## 使用

使用 `Zeroleaf\Kingsoft\Dict` 外观类:

``` php
use Zeroleaf\Kingsoft\Dict;

...

// 获取词典实例
$dict = Dict::getInstance();

// 搜索单词, 返回 Zeroleaf\Kingsoft\Dict\QueryResponse 实例
$word = $dict->query('wonderful');

// 单词联想, 返回 Zeroleaf\Kingsoft\Dict\SuggestionResponse 实例
$suggestion = $dict->suggest('h');
