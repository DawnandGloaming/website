<?php
namespace Common\Behavior;
use Think\Behavior;
/*行为执行入口*/
/**
 * @param mixed $param
 * $param['one']  第一个参数
 * $param['two']  第二个参数
 */
class HelloBehavior extends Behavior {
    public function run(&$params) {
        dump($params['one'] . $params['two'] . ' you');
    }
}