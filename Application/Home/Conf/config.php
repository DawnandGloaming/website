<?php
return array(
//    'URL_CASE_INSENSITIVE' => true,// 默认false 表示URL区分大小写 true则表示不区分大小写
    'LOAD_EXT_CONFIG'      => 'mysql',//加载扩展配置文件
    /*模板替换*/
    'TMPL_PARSE_STRING'    => array(
        '__JS__'           => __ROOT__.'/Public/'.MODULE_NAME.'/js',
        '__CSS__'          => __ROOT__.'/Public/'.MODULE_NAME.'/css',
        '__IMAGES__'       => __ROOT__.'/Public/'.MODULE_NAME.'/images',
        '__PLUGIN__'       => __ROOT__.'/Public/Plugin',
        '__COMMON__'       => __ROOT__.'/Public/Common',
    ),
    'VIEW_PATH'            => './Template/Pc/',//改变模块的模板文件目录
    'DEFAULT_THEME'        => 'english',// 默认模板主题名称
);