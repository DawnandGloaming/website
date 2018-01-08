<?php
return array(
    'view_filter' => array('Behavior\TokenBuildBehavior'),//表单令牌调用
    'app_begin' => array('Behavior\CheckLangBehavior'),//语言检测
    'hello' => array('Common\Behavior\HelloBehavior'),//测试钩子
);